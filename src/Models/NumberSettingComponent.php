<?php

namespace Vodeamanager\Core\Models;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class NumberSettingComponent extends BaseEntity
{
    protected $fillable = [
        'number_setting_id',
        'sequence',
        'type',
        'format',
    ];

    public function numberSetting() {
        return $this->belongsTo(config('vodeamanager.models.number_setting'));
    }

}
