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
            'file_name' => $this->file_name,
            'file_size' => $this->file_size,
            'file_extension' => $this->file_extension,
            'file_path' => $this->file_path,
            'file_storage' => $this->file_storage,
        ];
    }

}