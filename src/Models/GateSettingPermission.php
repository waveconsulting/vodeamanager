<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class GateSettingPermission extends Model implements Auditable
{
    use BaseEntity, AudibleTrait;

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
