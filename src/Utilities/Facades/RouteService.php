<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Support\Facades\Facade;

class RouteService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'route.service';
    }
}
