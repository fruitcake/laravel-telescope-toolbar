<?php

namespace Fruitcake\TelescopeToolbar;

use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\View;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;

class Toolbar
{
    private const KEY_REQUEST_STACK = '_tt.request_stack';

    protected $token = null;

    protected $redirectToken = null;

    /**
     * Get an unique token for this request to tie the Ajax request to.
     *
     * @return string
     */
    public function getDebugToken()
    {
        if (!$this->token) {
            $this->token = $this->findOrCreateEntryUuid();
        }

        return $this->token;
    }

    /**
     * We only need 1 UUID of an Entry from the current Request batch. If not available, create one
     *
     * @return string
     */
    private function findOrCreateEntryUuid()
    {
        // Use the first one if available
        if (isset(Telescope::$entriesQueue[0])) {
            $entry = Telescope::$entriesQueue[0];
        } else {
            // Create our own entry
            $entry = IncomingEntry::make([])->type('toolbar');
            Telescope::$entriesQueue[] = $entry;
        }

        return (string) $entry->uuid;
    }

    /**
     * @param \Illuminate\Http\Request $request A Request instance
     * @param \Illuminate\Http\Response $response A Response instance
     */
    public function modifyResponse($request, $response)
    {
        if ($request->is('_tt/*', config('telescope.path') . '*', '_debugbar/*') ) {
            return;
        }

        if ($response->isRedirection()) {
            $this->storeRedirectRequest($request, $response);
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
     * Store the current Request in the the session
     *
     * @param \Illuminate\Http\Request $request A Request instance
     * @param \Illuminate\Http\Response $response A Response instance
     */
    private function storeRedirectRequest($request, $response)
    {
        if (config('telescope-toolbar.store_redirects') && $request->hasSession()) {
            $requestStack = $this->getRequestStack($request, $response);
            $request->session()->put(self::KEY_REQUEST_STACK, $requestStack);
            $request->session()->reflash();
            $request->session()->save();
        }
    }

    /**
     * Injects the web debug toolbar into the given Response.
     *
     * @param \Illuminate\Http\Request $request A Request instance
     * @param \Illuminate\Http\Response $response A Response instance
     */
    private function injectToolbar($request, $response)
    {
        $content = $response->getContent();

        $token = $this->getDebugToken();

        $renderedContent = View::make('telescope-toolbar::widget', [
            'token' => $token,
            'requestStack' => $this->getRequestStack($request, $response),
            'excluded_ajax_paths' => config('laravel-telescope', '^/_tt|^/_debugbar'),
        ])->render();

        $pos = strripos($content, '</body>');
        if (false !== $pos) {
            $content = substr($content, 0, $pos) . $renderedContent . substr($content, $pos);
        } else {
            $content = $content . $renderedContent;
        }

        $original = null;
        if ($response instanceof IlluminateResponse && $response->getOriginalContent()) {
            $original = $response->getOriginalContent();
        }

        $response->setContent($content);

        // Restore original response (eg. the View or Ajax data)
        if ($original) {
            $response->original = $original;
        }
    }

    /**
     * Get the Request Stack
     *
     * @param \Illuminate\Http\Request $request A Request instance
     * @param \Illuminate\Http\Response $response A Response instance
     * @return array
     */
    private function getRequestStack($request, $response): array
    {
        if (config('telescope-toolbar.store_redirects') && $request->hasSession()) {
            $requestStack = $request->session()->pull(self::KEY_REQUEST_STACK, []);
            $request->session()->reflash();
            $request->session()->save();
        } else {
            $requestStack = [];
        }

        $requestStack[] = $this->getRequestData($request, $response);

        return $requestStack;
    }

    /**
     * Get the Request data
     *
     * @param \Illuminate\Http\Request $request A Request instance
     * @param \Illuminate\Http\Response $response A Response instance
     * @return array
     */
    private function getRequestData($request, $response) : array
    {
        $token = $this->getDebugToken();
        $path = $request->path();

        return [
            'error' => $response->getStatusCode() >= 500,
            'duration' => defined('LARAVEL_START') ? floor((microtime(true) - LARAVEL_START) * 1000) : 1,
            'statusCode' => $response->getStatusCode(),
            'url' =>  $path === '/' ? $path  : '/' . $path,
            'method' => $request->method(),
            'profile' => $token,
            'profilerUrl' => route('telescope-toolbar.show', ['token' => $token]),
            'type' => $response->isRedirection() ? 'other' : 'doc',
        ];
    }
}