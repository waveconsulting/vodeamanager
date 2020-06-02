<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class FileLog extends BaseEntity
{
    protected $fillable = [
        'file_name',
        'file_size',
        'file_extension',
        'file_path',
        'file_storage',
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

}