<?php

namespace Smoothsystem\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Gate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            abort(401);
        }

        $actionName = class_basename($request->route()->getActionname());
        if (!Auth::hasAuthority($actionName)) {
            abort(401);
        }

        return $next($request);
    }
}
