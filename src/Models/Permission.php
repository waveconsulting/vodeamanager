<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class Permission extends Model implements Auditable
{
    use BaseEntity, AudibleTrait;

    protected $fillable = [
        'name',
        'controller',
        'method',
    ];

}
