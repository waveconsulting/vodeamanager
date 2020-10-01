<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void log($e)
 * @method static JsonResponse responseJson($e)
 * @method static RedirectResponse response($e)
 *
 * @see \Vodeamanager\Core\Utilities\Services\ExceptionService
 */
class ExceptionService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'exception.service';
    }
}
