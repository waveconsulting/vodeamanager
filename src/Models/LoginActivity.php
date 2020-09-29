<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class LoginActivity extends Model
{
    use BaseEntity;

    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address',
    ];

    public function user() {
        return $this->belongsTo(config('vodeamanager.models.user'));
    }

}
