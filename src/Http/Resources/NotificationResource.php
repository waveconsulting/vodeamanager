<?php

namespace Vodeamanager\Core\Http\Resources;

class NotificationResource extends BaseResource
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
            'notification_type_id' => $this->notification_type_id,
            'data' => $this->data,
        ];
    }

}
