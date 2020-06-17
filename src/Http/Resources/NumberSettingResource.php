<?php

namespace Vodeamanager\Core\Http\Resources;

class NumberSettingResource extends BaseResource
{
    /**
     * @param $request
     * @return array
     */
    public function resource($request)
    {
        return [
            'name' => $this->name,
            'entity' => $this->entity,
            'reset_type' => $this->reset_type,
            'number_setting_components' => NumberSettingComponentResource::collection($this->whenLoaded('numberSettingComponents')),
        ];
    }

}
