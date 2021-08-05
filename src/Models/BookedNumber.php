<?php

namespace Vodeamanager\Core\Models;

use Vodeamanager\Core\Utilities\Models\BaseModel;

class BookedNumber extends BaseModel
{
    protected $fillable = [
        'subject_type',
        'subject_id',
        'number_setting_id',
        'number',
    ];

    public function numberSetting() {
        return $this->belongsTo(config('vodeamanager.models.number_setting'));
    }

}
