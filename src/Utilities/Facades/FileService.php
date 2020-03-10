<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Support\Facades\Facade;

class FileService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'file.service';
    }
}
