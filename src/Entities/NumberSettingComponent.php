<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Http\Resources\NumberSettingComponentResource;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class NumberSettingComponent extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        $this->indexResource = $this->showResource = $this->selectResource = NumberSettingComponentResource::class;

        parent::__construct($attributes);
    }

    protected $fillable = [
        'number_setting_id',
        'sequence',
        'type',
        'format',
    ];

    public function numberSetting() {
        return $this->belongsTo(NumberSetting::class);
    }

}
