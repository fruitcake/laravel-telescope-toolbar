<?php

namespace Fruitcake\TelescopeToolbar\Http\Middleware;

use Fruitcake\TelescopeToolbar\Toolbar;

class ToolbarMiddleware
{
    private $toolbar;

    public function __construct(Toolbar $toolbar)
    {
        $this->toolbar = $toolbar;
    }


    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        $response = $next($request);

        $this->toolbar->injectToolbar($response);

        return $response;
    }
}