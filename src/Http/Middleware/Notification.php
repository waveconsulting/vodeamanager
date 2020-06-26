<?php

namespace Vodeamanager\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Notification
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
        if (Auth::check() && $request->has('notif_id')) {
            $notificationId = $request->get('notif_id');

            if (!is_array($notificationId)) {
                $notificationId = [$notificationId];
            }

            Auth::user()->notifications()
                ->whereNull('notifications.read_at')
                ->whereIn('notifications.id', $notificationId)
                ->get()
                ->markAsRead();
        }

        return $next($request);
    }
}
