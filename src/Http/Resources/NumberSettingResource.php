<?php

namespace Vodeamanager\Core\Http\Resources;

class NumberSettingResource extends BaseResource
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
            'entity' => $this->entity,
            'reset_type' => $this->reset_type,
        ];
    }

}
