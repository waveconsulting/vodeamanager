<?php

namespace Vodeamanager\Core\Http\Resources;

class CreatorResource extends BaseResource
{
    /**
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
        ];
    }

}
