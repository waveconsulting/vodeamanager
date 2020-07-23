<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string generateNumber(string $entity, $date = null, $subjectId = null)
 *
 * @see \Vodeamanager\Core\Utilities\Services\NumberSettingService
 */
class NumberSettingService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'number-setting.service';
    }
}
