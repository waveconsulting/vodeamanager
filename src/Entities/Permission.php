<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Http\Resources\PermissionResource;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Permission extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->indexResource = $this->showResource = $this->selectResource = PermissionResource::class;
    }

    protected $fillable = [
        'name',
        'controller',
        'method',
    ];

    public function gateSettingPermissions()
    {
        return $this->hasMany(config('vodeamanager.models.gate_permission_setting'));
    }

    public function gateSetting()
    {
        return $this->belongsToMany(config('vodeamanager.models.gate_setting'), 'gate_setting_permissions')->withTimestamps();
    }

}
