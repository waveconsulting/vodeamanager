<?php

namespace Vodeamanager\Core\Models;

use Vodeamanager\Core\Utilities\Models\BaseModel;

class GateSettingPermission extends BaseModel
{
    protected $fillable = [
        'gate_setting_id',
        'permission_id',
    ];

    public function gateSetting()
    {
        return $this->belongsTo(config('vodeamanager.models.gate_setting'));
    }

    public function permission()
    {
        return $this->belongsTo(config('vodeamanager.models.permission'));
    }

}
