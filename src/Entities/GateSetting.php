<?php

namespace Vodeamanager\Core\Entities;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Vodeamanager\Core\Rules\ValidUser;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class GateSetting extends BaseEntity
{
    protected $fillable = [
        'role_id',
        'user_id',
        'valid_from',
    ];

    protected $dates = [
        'valid_from',
    ];

    protected $validationRules = [
        'valid_from' => 'required|date_format:Y-m-d',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            if (!$data->valid_from) $data->valid_from = Carbon::now();
        });
    }

    public function role() {
        return $this->belongsTo(config('vodeamanager.entities.role'));
    }

    public function user() {
        return $this->belongsTo(config('vodeamanager.entities.user'));
    }

    public function gateSettingPermissions() {
        return $this->hasMany(config('vodeamanager.models.gate_permission_setting'));
    }

    public function permissions() {
        return $this->belongsToMany(config('vodeamanager.models.permission'), 'gate_setting_permissions')->withTimestamps();
    }

    public function setValidationRules(array $request = [], $id = null)
    {
        $this->validationRules['role_id'] = 'required|exists:roles,id,deleted_at,NULL';

        if (!Arr::get($request,'role_id')) $this->validationRules['user_id'] = ['required', new ValidUser()];

        $this->validationRules['permission_ids'] = 'array';
        $this->validationRules['permission_ids.*'] = 'required|exists:permissions,id,deleted_at,NULL';
    }

}
