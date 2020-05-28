<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Setting extends BaseEntity
{
    protected $fillable = [
        'type',
        'data',
    ];

    protected $casts = [
        'data' => 'object',
    ];

}
