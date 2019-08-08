<?php

namespace Fruitcake\TelescopeToolbar\Http\Middleware;

class ToolbarMiddleware
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return $next($request);
    }
}