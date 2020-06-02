<?php

namespace Vodeamanager\Core\Entities;

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

}