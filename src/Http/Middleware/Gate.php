<?php

namespace Vodeamanager\Core\Http\Middleware;

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
            return abort(401);
        }

        $actionName = class_basename($request->route()->getName());
        if (!Auth::user()->authorized($actionName)) {
            return abort(401);
        }

        return $next($request);
    }
}
