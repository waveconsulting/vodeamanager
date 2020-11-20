<?php

namespace Vodeamanager\Core\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
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
            $name = Str::snake($relationName);
            if (array_key_exists($name,$resources)) {
                continue;
            }

            $resources[$name] = $this->whenLoaded($relationName, function () use ($relationName) {
                $data = $resource = $this->resource->$relationName;
                $resource = BaseResource::class;

                if ($data instanceof Collection) {
                    if ($data->isNotEmpty()) {
                        $resource = $data[0]->getResource();
                    }

                    return $resource::collection($data);
                }

                if ($data instanceof Pivot) {
                    return $data;
                } else if (!empty($data)) {
                    $resource = $data->getResource();
                }

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
        $fields = array_diff($this->resource->getFillable(), $this->resource->getHidden());

        $resources = [];
        foreach ($fields as $field) {
            $resources[$field] = $this->$field;
        }

        return $resources;
    }
}
