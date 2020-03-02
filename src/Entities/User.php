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
        return $this->belongsToMany(config('vodeamanager.models.role'), 'role_users')->withTimestamps();
    }

    public function roleUsers() {
        return $this->hasMany(config('vodeamanager.models.role_user'));
    }

    public function getRoleUserAttribute($date = null) {
        if (empty($date)) {
            $date = now()->toDateString();
        }

        return $this->roleUsers()->whereDate('role_users.valid_from', $date)
            ->orderByDesc('role_users.valid_from')
            ->first();
    }

    public function getRoleAttribute() {
        $roleUser = $this->roleUser;

        return $roleUser ? $roleUser->role : null;
    }

    public function getRoleNameAttribute() {
        return $this->role ? $this->role->getLabel() : null;
    }

    public function authorized($action) {

        return true;
    }

}
