<?php

namespace Vodeamanager\Core\Models;

use Vodeamanager\Core\Utilities\Models\BaseModel;

class Setting extends BaseModel
{
    protected $fillable = [
        'type',
        'attributes',
    ];

    protected $casts = [
        'attributes' => 'object',
    ];

}
