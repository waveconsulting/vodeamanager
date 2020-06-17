<?php

namespace Vodeamanager\Core\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resources = array_merge([
            'id' => $this->id,
            'creator' => new CreatorResource($this->whenLoaded('creator')),
            'editor' => new EditorResource($this->whenLoaded('editor')),
            'destroyer' => new DestroyerResource($this->whenLoaded('destroyer')),
        ], $this->resource($request));

        foreach (array_keys($this->getRelations()) as $relationName) {
            $name = camel_to_snake($relationName);
            if (array_key_exists($name,$resources)) continue;

            $resources[$name] = $this->whenLoaded($relationName, function () use ($relationName) {
                $data = $resource = $this->resource->$relationName;
                if ($data instanceof Collection) {
                    if ($data->isEmpty()) $resource = DefaultResource::class;
                    else $resource = $data[0]->getResource();

                    return $resource::collection($data);
                }
                else if (empty($data)) $resource = DefaultResource::class;
                else $resource = $data->getResource();

                return new $resource($data);
            });
        }

        return $resources;
    }

    /**
     * @param  Request  $request
     * @return array
     */
    public function resource($request)
    {
        return [];
    }
}
