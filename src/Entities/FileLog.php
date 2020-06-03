<?php

namespace Vodeamanager\Core\Entities;

use Illuminate\Support\Facades\Storage;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class FileLog extends BaseEntity
{
    protected $fillable = [
        'name',
        'encoded_name',
        'size',
        'extension',
        'path',
        'disk',
    ];

    protected $validationRules = [
        'file' => [
            'required',
        ],
        'path' => [
            'required',
            'string',
        ],
    ];

    public function getUrlAttribute() {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function setValidationRules(array $request = [], $id = null)
    {
        $this->validationRules['disk'] = [
            'required',
            'in:' . implode(array_keys(config('filesystems.disks', [])), ',')
        ];

        return $this;
    }

    public function setValidationMessages(array $request = [])
    {
        $this->validationMessages['disk.in'] = 'The selected :attribute must be in '
            . implode(array_keys(config('filesystems.disks', [])), ',');

        return $this;
    }

}