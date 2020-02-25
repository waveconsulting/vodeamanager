<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Role extends BaseEntity
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'parent_id',
        'is_special',
    ];

    public function parent() {
        return $this->belongsTo(config('vodeamanager.models.role'))->with('parent');
    }

    public function children() {
        return $this->hasMany(config('vodeamanager.models.role'),'parent_id')->with('children');
    }

    public function roleUsers() {
        return $this->hasMany(config('vodeamanager.models.role_user'));
    }

    public function gateSettings() {
        return $this->hasMany(config('vodeamanager.models.gate_setting'));
    }

    public function users() {
        return $this->belongsToMany(config('vodeamanager.models.user'), 'role_users');
    }
}
