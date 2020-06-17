<?php

namespace Vodeamanager\Core\Http\Resources;

class NotificationUserResource extends BaseResource
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
            'notification_id' => $this->notification_id,
            'user_id' => $this->user_id,
            'is_read' => $this->is_read,
        ];
    }

}
