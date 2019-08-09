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

    protected $redirectToken = null;

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
            if ($request->hasSession()) {
                $this->redirectToken = $request->session()->pull(self::KEY_REDIRECT_TOKEN);
                if ($this->redirectToken) {
                    $request->session()->save();
                }
            }

            $entry = IncomingEntry::make([
                'redirect_token' => $this->redirectToken
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

        // Skip non-html requests
        if (($response->headers->has('Content-Type') && strpos($response->headers->get('Content-Type'), 'html') === false)
            || $request->getRequestFormat() !== 'html'
            || stripos($response->headers->get('Content-Disposition'), 'attachment;') !== false
        ) {
            return;
        }

        $this->injectToolbar($request, $response);
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

        $token = $this->getDebugToken($request);

        $renderedContent = View::make('telescope-toolbar::widget', [
                'token' => $token,
                'requestStack' => $this->getRequestStack($request, $response),
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

    /**
     * Get the Request Stack
     *
     * @param \Illuminate\Http\Request $request A Request instance
     * @param \Illuminate\Http\Response $response A Response instance
     * @return array
     */
    protected function getRequestStack($request, $response) : array
    {
        $token = $this->getDebugToken($request);

        $current = [
            'error' => $response->getStatusCode() >= 500,
            'duration' => defined('LARAVEL_START') ? floor((microtime(true) - LARAVEL_START) * 1000) : 1,
            'statusCode' => $response->getStatusCode(),
            'url' => '/' . ltrim($request->path(). '/'),
            'method' => $request->method(),
            'profile' => $token,
            'profilerUrl' => route('telescope-toolbar.show', ['token' => $token]),
            'type' => 'doc',
        ];

        return [
            $current,
        ];
    }
}