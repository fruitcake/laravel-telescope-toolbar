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
    public function getRequestToken()
    {
        return uniqid();  // TODO; make useful
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
                'token' => $this->getRequestToken(),
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