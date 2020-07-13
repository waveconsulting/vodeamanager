<?php

namespace Vodeamanager\Core\Listeners;

use Illuminate\Support\Facades\Request;
use Laravel\Passport\Events\AccessTokenCreated;

class TokenSuccessfulGenerate
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
     * @param  AccessTokenCreated  $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        config('vodeamanager.models.login_activity')::disableAuditing();

        config('vodeamanager.models.login_activity')::create([
            'user_id'       =>  $event->userId,
            'user_agent'    =>  Request::header('User-Agent'),
            'ip_address'    =>  Request::ip()
        ]);

        config('vodeamanager.models.login_activity')::enableAuditing();
    }
}
