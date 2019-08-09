<?php

namespace Fruitcake\TelescopeToolbar;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;

class Toolbar
{
    private const KEY_REDIRECT_TOKEN = '_tt_redirect_token';

    protected $token = null;

    /**
     * Get an unique token for this request to tie the Ajax request to.
     *
     * @param \Illuminate\Http\Request $request A Request instance
     * @return string
     */
    public function getDebugToken($request)
    {
        if (!$this->token) {

            // Save a redirect token from the session
            $redirectToken = null;
            if ($request->hasSession()) {
                $redirectToken = $request->session()->pull(self::KEY_REDIRECT_TOKEN);
                if ($redirectToken) {
                    $request->session()->save();
                }
            }

            $entry = IncomingEntry::make([
                'redirect_token' => $redirectToken
            ])->type('toolbar');

            Telescope::$entriesQueue[] = $entry;

            $this->token = (string) $entry->uuid;
        }

        return $this->token;
    }


    /**
     * @param \Illuminate\Http\Request $request A Request instance
     * @param \Illuminate\Http\Response $response A Response instance
     */
    public function modifyResponse($request, $response)
    {
        if ($request->is('_tt/*', config('telescope.path') . '/*') ) {
            return;
        }

        if ($response->isRedirection()) {

            if ($request->hasSession()) {
                $request->session()->put(self::KEY_REDIRECT_TOKEN, $this->getDebugToken($request));
                $request->session()->save();
            }

            return;
        }


        // Inject headers in Ajax Requests
        if ($request->ajax()) {
            $response->header('x-debug-token', $this->getDebugToken($request));
            $response->header('x-debug-token-link', route('telescope-toolbar.show', [$this->getDebugToken($request)]));

            if (config('telescope-toolbar.replace')) {
                $response->header('Symfony-Debug-Toolbar-Replace', 1);
            }

            return;
        }

        if (
            $response->headers->has('Content-Type')
            &&  strpos($response->headers->get('Content-Type'), 'html') !== false
            && $request->getRequestFormat() === 'html'
            && $response->getContent()
        ) {
            $this->injectToolbar($request, $response);
            return;
        }
    }

    /**
     * Injects the web debug toolbar into the given Response.
     *
     * @param \Illuminate\Http\Request $request A Request instance
     * @param \Illuminate\Http\Response $response A Response instance
     */
    public function injectToolbar($request, $response)
    {
        $content = $response->getContent();

        $renderedContent = View::make('telescope-toolbar::widget', [
                'token' => $this->getDebugToken($request),
                'statusCode' => $response->getStatusCode(),
                'duration' => defined('LARAVEL_START') ? floor((microtime(true) - LARAVEL_START) * 1000) : null,
                'excluded_ajax_paths' => '^/_tt'
            ])->render();

        $pos = strripos($content, '</body>');
        if (false !== $pos) {
            $content = substr($content, 0, $pos) . $renderedContent . substr($content, $pos);
        } else {
            $content = $content . $renderedContent;
        }

        $response->setContent($content);
    }
}