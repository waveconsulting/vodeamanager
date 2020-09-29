<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class NumberSettingComponent extends Model implements Auditable
{
    use BaseEntity, AudibleTrait;

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
