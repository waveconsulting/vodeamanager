<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void fileService()
 * @method static void notificationService()
 * @method static void numberSettingService()
 *
 * @see \Vodeamanager\Core\Utilities\Services\RouteService
 */
class RouteService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'route.service';
    }
}
