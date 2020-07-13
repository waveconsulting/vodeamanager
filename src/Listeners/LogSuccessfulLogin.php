<?php

namespace Vodeamanager\Core\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        config('vodeamanager.models.login_activity')::disableAuditing();

        config('vodeamanager.models.login_activity')::create([
            'user_id'       =>  $event->user->id,
            'user_agent'    =>  Request::header('User-Agent'),
            'ip_address'    =>  Request::ip()
        ]);

        config('vodeamanager.models.login_activity')::enableAuditing();
    }
}
