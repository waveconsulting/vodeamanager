<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Http\Resources\GateSettingResource;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class GateSettingPermission extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        $this->indexResource = $this->showResource = $this->selectResource = GateSettingResource::class;

        parent::__construct($attributes);
    }

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
