<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Permission extends BaseEntity
{
    protected $fillable = [
        'name',
        'controller',
        'method',
    ];

    protected $validationRules = [
        'name' => [
            'required',
            'string',
            'max:255',
        ],
        'controller' => [
            'required',
            'string',
            'max:255',
        ],
        'method' => [
            'required',
            'string',
            'max:255',
        ]
    ];

    public function gateSettingPermissions() {
        return $this->hasMany(config('vodeamanager.models.gate_permission_setting'));
    }

    public function gateSetting() {
        return $this->belongsToMany(config('vodeamanager.models.gate_setting'), 'gate_setting_permissions')->withTimestamps();
    }

}
