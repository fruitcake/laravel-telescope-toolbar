<?php

namespace Fruitcake\TelescopeToolbar;

use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\View;
use Laravel\Telescope\IncomingDumpEntry;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class Toolbar
{
    public const ASSET_VERSION = '20190826';
    private const KEY_REQUEST_STACK = '_tt.request_stack';

    protected $token = null;

    protected $redirectToken = null;

    public static function dump(...$args)
    {
        foreach ($args as $var) {
            Telescope::recordDump(
                IncomingDumpEntry::make(['dump' =>  (new HtmlDumper)->dump(
                    (new VarCloner)->cloneVar($var), true
                )])
            );
        }
    }
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
     * @param \Symfony\Component\HttpFoundation\Response $response A Response instance
     */
    public function modifyResponse($request, $response)
    {
        if ($request->is(config('telescope-toolbar.path').'/*', config('telescope.path') . '*', '_debugbar/*') ) {
            return;
        }

        if ($response->isRedirection()) {
            $this->storeRedirectRequest($request, $response);
            return;
        }


        // Inject headers in Ajax Requests
        if ($request->ajax() || $request->headers->get('X-Livewire')) {
            $response->headers->set('x-debug-token', $this->getDebugToken($request));
            $response->headers->set('x-debug-token-link', route('telescope-toolbar.show', [$this->getDebugToken($request)]));

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
     * @param \Symfony\Component\HttpFoundation\Response $response A Response instance
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
     * @param \Symfony\Component\HttpFoundation\Response $response A Response instance
     */
    private function injectToolbar($request, $response)
    {
        $content = $response->getContent();

        $token = $this->getDebugToken();

        $head = View::make('telescope-toolbar::head', [
            'assetVersion' => static::ASSET_VERSION,
            'lightMode' => config('telescope-toolbar.light_theme') === 'auto' ? 'auto'
                        : (config('telescope-toolbar.light_theme') ? 1 : 0),
            'requestStack' => $this->getRequestStack($request, $response),
        ])->render();

        $widget = View::make('telescope-toolbar::widget', [
            'token' => $token,
        ])->render();

        // Try to put the js/css directly before the </head>
        $pos = strripos($content, '</head>');
        if (false !== $pos) {
            $content = substr($content, 0, $pos) . $head . substr($content, $pos);
        } else {
            // Append the head before the widget
            $widget = $head . $widget;
        }

        // Try to put the widget at the end, directly before the </body>
        $pos = strripos($content, '</body>');
        if (false !== $pos) {
            $content = substr($content, 0, $pos) . $widget . substr($content, $pos);
        } else {
            $content = $content . $widget;
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
     * @param \Symfony\Component\HttpFoundation\Response $response A Response instance
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
     * @param \Symfony\Component\HttpFoundation\Response $response A Response instance
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
