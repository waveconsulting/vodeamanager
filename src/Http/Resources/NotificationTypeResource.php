<?php

namespace Vodeamanager\Core\Http\Resources;

class NotificationTypeResource extends BaseResource
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
            'code' => $this->code,
            'name' => $this->name,
            'icon' => $this->icon,
            'hex_color' => $this->hex_color,
        ];
    }

}
