<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Support\Facades\Facade;

class NumberSettingService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'number-setting.service';
    }
}
