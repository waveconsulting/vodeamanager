<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Support\Carbon;
use Vodeamanager\Core\Rules\ValidUser;
use Vodeamanager\Core\Utilities\Models\BaseModel;

class GateSetting extends BaseModel
{
    protected $fillable = [
        'role_id',
        'user_id',
        'valid_from',
    ];

    protected $validationRules = [
        'role_id' => 'required_without:user_id|exists:roles,id,deleted_at,NULL',
        'valid_from' => 'nullable|date_format:Y-m-d',
        'permission_ids' => 'nullable|array',
        'permission_ids.*' => 'required|exists:permissions,id,deleted_at,NULL',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            if (is_null($data->valid_from)) {
                $data->valid_from = Carbon::now()->toDateString();
            }
        });
    }

    public function role()
    {
        return $this->belongsTo(config('vodeamanager.models.role'));
    }

    public function user()
    {
        return $this->belongsTo(config('vodeamanager.models.user'));
    }

    public function gateSettingPermissions()
    {
        return $this->hasMany(config('vodeamanager.models.gate_setting_permission'));
    }

    public function permissions()
    {
        return $this->belongsToMany(config('vodeamanager.models.permission'), 'gate_setting_permissions')->withTimestamps();
    }

    public function setValidationRules(array $request = [], $id = null)
    {
        $this->validationRules['user_id'] = [
            'required_without:role_id',
            new ValidUser(),
        ];

        return $this;
    }

}
