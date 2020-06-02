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
        'disk' => [
            'required',
            'string',
        ]
    ];

    public function getUrlAttribute() {
        return Storage::disk($this->disk)->url($this->path);
    }

}