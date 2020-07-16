<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Support\Facades\Facade;

class FileLogService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'file_log.service';
    }
}
