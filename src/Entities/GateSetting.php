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
        return $this->belongsTo(config('smoothsystem.entities.role'));
    }

    public function user() {
        return $this->belongsTo(config('smoothsystem.entities.user'));
    }

    public function permissions() {
        return $this->belongsToMany(config('smoothsystem.models.permission'),'gate_setting_permissions');
    }

    public function gateSettingPermissions() {
        return $this->hasMany(config('smoothsystem.models.gate_permission_setting'));
    }
}
