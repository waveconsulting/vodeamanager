<?php

namespace Vodeamanager\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Log
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
        if (Auth::check()) {
            Auth::user()->userLogs()->create([
                'action' => $request->route()->getName(),
                'request' => $request->all(),
            ]);
        }

        return $next($request);
    }
}
