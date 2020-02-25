<?php

namespace Smoothsystem\Core\Listeners;

use Illuminate\Support\Facades\Request;
use Laravel\Passport\Events\AccessTokenCreated;
use Smoothsystem\Core\Entities\LoginActivity;

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
        LoginActivity::create([
            'user_id'       =>  $event->userId,
            'user_agent'    =>  Request::header('User-Agent'),
            'ip_address'    =>  Request::ip()
        ]);
    }
}
