<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class Permission extends Model
{
    use BaseEntity;

    protected $fillable = [
        'name',
        'controller',
        'method',
    ];

}
