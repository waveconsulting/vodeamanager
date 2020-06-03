<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class UserLog extends BaseEntity
{
    protected $fillable = [
        'user_id',
        'path',
        'action',
        'request',
    ];

    protected $casts = [
        'request' => 'object'
    ];

    public function user() {
        return $this->belongsTo(config('vodeamanager.models.user'));
    }

}
