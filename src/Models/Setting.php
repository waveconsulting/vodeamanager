<?php

namespace Vodeamanager\Core\Models;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Setting extends BaseEntity
{
    protected $fillable = [
        'type',
        'attributes',
    ];

    protected $casts = [
        'attributes' => 'object',
    ];

}
