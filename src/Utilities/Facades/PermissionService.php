<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Support\Facades\Facade;

class PermissionService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'permission.service';
    }
}
