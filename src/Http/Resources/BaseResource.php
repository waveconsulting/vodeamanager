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
        $defaultResources = [
            'id' => $this->id,
            'creator' => new CreatorResource($this->whenLoaded('creator')),
            'editor' => new EditorResource($this->whenLoaded('editor')),
            'destroyer' => new DestroyerResource($this->whenLoaded('destroyer')),
        ];

        $relations = [];
        foreach (array_keys($this->getRelations()) as $relationName) {
            $relation = camel_to_snake($relationName);
            $relations[$relation] = $this->whenLoaded($relationName, function () use ($relationName) {

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

        return array_merge($defaultResources, $this->resource($request), $relations);
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
