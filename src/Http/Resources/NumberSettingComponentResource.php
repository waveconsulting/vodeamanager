<?php

namespace Vodeamanager\Core\Http\Resources;

class NumberSettingComponentResource extends BaseResource
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
            'number_setting_id' => $this->number_setting_id,
            'sequence' => $this->sequence,
            'type' => $this->type,
            'format' => $this->format,
        ];
    }

}
