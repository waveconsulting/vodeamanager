<?php

namespace Vodeamanager\Core\Http\Resources;

class FileLogResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function resource($request)
    {
        $resources = parent::resource($request);

        return array_merge($resources, [
            'url' => $this->url,
        ]);
    }

}
