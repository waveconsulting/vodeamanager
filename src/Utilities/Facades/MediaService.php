<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void logUse(Model $model, string $relationName)
 *
 * @see \Vodeamanager\Core\Utilities\Services\MediaService
 */
class MediaService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'media.service';
    }
}
