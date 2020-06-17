<?php

namespace Vodeamanager\Core\Http\Resources;

class NumberSettingComponentResource extends BaseResource
{
    /**
     * @param $request
     * @return array
     */
    public function resource($request)
    {
        return [
            'number_setting_id' => $this->number_setting_id,
            'number_setting' => new NumberSettingResource($this->whenLoaded('numberSetting')),
            'sequence' => $this->sequence,
            'type' => $this->type,
            'format' => $this->format,
        ];
    }

}
