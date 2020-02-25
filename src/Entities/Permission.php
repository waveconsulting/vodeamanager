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

    public function gateSettingPermissions() {
        return $this->hasMany(config('vodeamanager.models.gate_permission_setting'));
    }

    public function gateSetting() {
        return $this->belongsTo(config('vodeamanager.models.gate_setting'));
    }

}
