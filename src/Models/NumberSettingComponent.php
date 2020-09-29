<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class NumberSettingComponent extends Model
{
    use BaseEntity;

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
