<?php

namespace Vodeamanager\Core\Http\Resources;

class LoginActivityResource extends BaseResource
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
            'user_id' => $this->user_id,
            'user_agent' => $this->user_agent,
            'ip_address' => $this->ip_address,
        ];
    }

}
