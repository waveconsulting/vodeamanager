<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class Setting extends Model
{
    use BaseEntity;

    protected $fillable = [
        'type',
        'attributes',
    ];

    protected $casts = [
        'attributes' => 'object',
    ];

}
