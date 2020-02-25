<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsToMany(config('smoothsystem.models.role'), 'role_users');
    }

    public function roleUsers() {
        return $this->hasMany(config('smoothsystem.models.role_user'));
    }

    public function getRoleUserAttribute() {
        return $this->roleUsers()->orderByDesc('valid_from')->first();
    }

    public function getRoleAttribute() {
        $roleUser = $this->roleUser;

        return $roleUser ? $roleUser->role : null;
    }

    public function getRoleNameAttribute() {
        return $this->role ? $this->role->getLabel() : null;
    }
}
