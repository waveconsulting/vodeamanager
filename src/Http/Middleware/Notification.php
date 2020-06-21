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
        if (Auth::check() && $notificationId = $request->get('notification_id')) {
            if (!is_array($notificationId)) {
                $notificationId = [$notificationId];
            }

            $notifications = config('vodeamanger.models.notification_user')::notRead()
                ->whereIn('notification_users.notification_id', $notificationId)
                ->get();

            foreach ($notifications as $notification) {
                $notification->is_read = 1;
                $notification->save();
            }
        }

        return $next($request);
    }
}
