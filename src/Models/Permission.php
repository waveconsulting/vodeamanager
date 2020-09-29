<?php

namespace Vodeamanager\Core\Models;

use Vodeamanager\Core\Utilities\Models\BaseModel;

class Permission extends BaseModel
{
    protected $fillable = [
        'name',
        'controller',
        'method',
    ];

}
