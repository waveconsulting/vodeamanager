<?php

namespace Vodeamanager\Core\Models;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class LoginActivity extends BaseEntity
{
    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address',
    ];

    public function user() {
        return $this->belongsTo(config('vodeamanager.models.user'));
    }

}
