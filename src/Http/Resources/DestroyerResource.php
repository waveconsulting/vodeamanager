<?php

namespace Vodeamanager\Core\Http\Resources;

class DestroyerResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function resource($request)
    {
        return [
            'name' => $this->name,
        ];
    }

}
