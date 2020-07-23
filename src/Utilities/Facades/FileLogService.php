<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Support\Facades\Facade;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

/**
 * @method static void logUse(BaseEntity $model, string $relationName)
 *
 * @see \Vodeamanager\Core\Utilities\Services\FileLogService
 */
class FileLogService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'file_log.service';
    }
}
