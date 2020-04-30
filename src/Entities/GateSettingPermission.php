<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class GateSettingPermission extends BaseEntity
{
    protected $fillable = [
        'gate_setting_id',
        'permission_id',
    ];

    protected $validationRules = [
        'gate_setting_id' => [
            'required',
            'exists:gate_settings,id,deleted_at,NULL',
        ],
        'permission_id' => [
            'required',
            'exists:permissions,id,deleted_at,NULL',
        ],
    ];

    public function gateSetting() {
        return $this->belongsTo(config('vodeamanager.models.gate_setting'));
    }

    public function permission() {
        return $this->belongsTo(config('vodeamanager.models.permission'));
    }

}
