<?php

namespace Vodeamanager\Core\Http\Resources;

class SettingResource extends BaseResource
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
            'type' => $this->type,
            'attributes' => $this->attributes,
        ];
    }

}
