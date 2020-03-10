<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Support\Facades\Facade;

class ExceptionService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'exception.service';
    }
}
