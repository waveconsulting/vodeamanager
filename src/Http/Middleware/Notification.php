<?php

namespace Vodeamanager\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Notification
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
        if (Auth::check() && $request->has('notification_id') && $notification = config('vodeamanger.models.notification_user')
                ::where('notification_users.notification_id', $request->get('notification_id'))
                ->where('notification_users.user_id', Auth::id())->first()) {
            $notification->is_read = 1;
            $notification->save();
        }

        return $next($request);
    }
}
