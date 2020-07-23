<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array store(Request $request, string $key, string $disk, string $path)
 *
 * @see \Vodeamanager\Core\Utilities\Services\FileService
 */
class FileService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'file.service';
    }
}
