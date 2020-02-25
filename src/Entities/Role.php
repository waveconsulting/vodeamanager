<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Role extends BaseEntity
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'is_special',
    ];

    public function users() {
        return $this->belongsToMany(config('smoothsystem.models.user'), 'role_users');
    }

    public function roleUsers() {
        return $this->hasMany(config('smoothsystem.models.role_user'));
    }
}
