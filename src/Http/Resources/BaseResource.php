<?php

namespace Vodeamanager\Core\Http\Resources;

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

        return array_merge($defaultResources, $this->resource($request));
    }

    /**
     * @param $request
     * @return array
     */
    public function resource($request) {
        return [];
    }
}