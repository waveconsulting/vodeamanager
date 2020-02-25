<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class GateSetting extends BaseEntity
{
    protected $fillable = [
        'role_id',
        'user_id',
        'valid_from',
    ];

    public function role() {
        return $this->belongsTo(config('vodeamanager.entities.role'));
    }

    public function user() {
        return $this->belongsTo(config('vodeamanager.entities.user'));
    }

    public function gateSettingPermissions() {
        return $this->hasMany(config('vodeamanager.models.gate_permission_setting'));
    }

    public function permissions() {
        return $this->belongsToMany(config('vodeamanager.models.permission'), 'gate_setting_permissions');
    }

}
