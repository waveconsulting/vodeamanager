<?php

namespace Vodeamanager\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Gate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return abort(401);
        }

        $name = class_basename($request->route()->getName());
        if (!Auth::user()->authorized($name)) {
            return abort(401);
        }

        return $next($request);
    }
}
