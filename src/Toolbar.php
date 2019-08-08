<?php

namespace Fruitcake\TelescopeToolbar;

use Illuminate\Support\Facades\View;

class Toolbar
{
    /**
     * Get an unique token for this request to tie the Ajax request to.
     *
     * @return string
     */
    public function getDebugToken()
    {
        return uniqid();  // TODO; make useful
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

        // TODO; what to do?
        if ($response->isRedirection()) {
            return;
        }


        // Inject headers in Ajax Requests
        if ($request->ajax()) {
            $response->header('x-debug-token', $this->getDebugToken());
            $response->header('x-debug-token-link', route('telescope'));

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
        )        {
            $this->injectToolbar($response);
            return;
        }
    }

    /**
     * Injects the web debug toolbar into the given Response.
     *
     * @param \Illuminate\Http\Response $response A Response instance
     */
    public function injectToolbar($response)
    {
        $content = $response->getContent();

        $renderedContent = View::make('telescope-toolbar::widget', [
                'token' => $this->getDebugToken(),
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