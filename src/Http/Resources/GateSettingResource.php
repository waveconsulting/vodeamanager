<?php

namespace Vodeamanager\Core\Http\Resources;

class GateSettingResource extends BaseResource
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
            'role_id' => $this->role_id,
            'user_id' => $this->user_id,
            'valid_from' => $this->valid_from,
        ];
    }

}
