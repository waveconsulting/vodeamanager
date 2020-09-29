<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vodeamanager\Core\Rules\ValidUser;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class GateSetting extends Model implements Auditable
{
    use BaseEntity, AudibleTrait;
    
    protected $fillable = [
        'role_id',
        'user_id',
        'valid_from',
    ];

    protected $validationRules = [
        'role_id' => 'required_without:user_id|exists:roles,id,deleted_at,NULL',
        'valid_from' => 'required|date_format:Y-m-d',
        'permission_ids' => 'required|array|min:1',
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
        return $this->belongsTo(config('vodeamanager.entities.role'));
    }

    public function user()
    {
        return $this->belongsTo(config('vodeamanager.entities.user'));
    }

    public function gateSettingPermissions()
    {
        return $this->hasMany(config('vodeamanager.models.gate_permission_setting'));
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
