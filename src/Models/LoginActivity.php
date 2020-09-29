<?php

namespace Vodeamanager\Core\Models;

use Vodeamanager\Core\Utilities\Models\BaseModel;

class LoginActivity extends BaseModel
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
