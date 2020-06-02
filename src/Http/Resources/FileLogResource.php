<?php

namespace Vodeamanager\Core\Http\Resources;

class FileLogResource extends BaseResource
{
    /**
     * @param $request
     * @return array
     */
    public function resource($request) {
        return [
            'name' => $this->name,
            'encoded_name' => $this->encoded_name,
            'size' => $this->size,
            'extension' => $this->extension,
            'path' => $this->path,
            'disk' => $this->disk,
        ];
    }

}