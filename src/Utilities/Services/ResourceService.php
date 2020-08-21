<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Vodeamanager\Core\Http\Resources\BaseResource;

class ResourceService
{
    /**
     * @param $resource
     * @param $data
     * @param array $additional
     *
     * @return AnonymousResourceCollection
     */
    public function jsonCollection($resource, $data, $additional = [])
    {
        if ($resource && is_subclass_of($resource, JsonResource::class)) {
            return $resource::collection($data)->additional($additional);
        }

        return BaseResource::collection($data)->additional($additional);
    }

    /**
     * @param $resource
     * @param $data
     * @param array $additional
     *
     * @return BaseResource
     */
    public function jsonResource($resource, $data, $additional = [])
    {
        if ($resource && is_subclass_of($resource, JsonResource::class)) {
            return (new $resource($data))->additional($additional);
        }

        return (new BaseResource($data))->additional($additional);
    }
}
