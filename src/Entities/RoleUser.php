<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class RoleUser extends BaseEntity
{
    protected $fillable = [
        'role_id',
        'user_id',
        'valid_from',
    ];

    public function user() {
        return $this->belongsTo(config('smoothsystem.models.user'));
    }

    public function role() {
        return $this->belongsTo(config('smoothsystem.models.role'));
    }

}
