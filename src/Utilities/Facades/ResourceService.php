<?php

namespace Vodeamanager\Core\Utilities\Facades;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Facade;
use Vodeamanager\Core\Http\Resources\BaseResource;

/**
 * @method static AnonymousResourceCollection jsonCollection($resource, $data, $additional = [])
 * @method static BaseResource jsonResource($resource, $data, $additional = [])
 *
 * @see \Vodeamanager\Core\Utilities\Services\ResourceService
 */
class ResourceService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'resource.service';
    }
}
