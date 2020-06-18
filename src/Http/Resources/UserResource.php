<?php

namespace Vodeamanager\Core\Http\Resources;

class UserResource extends BaseResource
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
            'email' => $this->email,
            'telephone' => $this->telephone,
            'mobile_phone' => $this->mobile_phone,
            'photo_id' => $this->photo_id,
        ];
    }

}
