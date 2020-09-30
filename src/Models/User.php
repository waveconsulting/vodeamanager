<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Support\Carbon;
use Vodeamanager\Core\Utilities\Models\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'mobile_phone',
        'photo_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $validationRules = [
        'name' => 'required|string|max:255',
        'password' => 'required|string|max:255',
        'telephone' => 'nullable|string|max:15',
        'mobile_phone' => 'nullable|string|max:15',
        'photo_id' => 'nullable|exists:media,id,deleted_at,NULL',
    ];

    public function photo() {
        return $this->belongsTo(config('vodeamanager.models.media'),'photo_id');
    }

    public function roles() {
        return $this->belongsToMany(config('vodeamanager.models.role'), 'role_users')->withTimestamps();
    }

    public function roleUsers() {
        return $this->hasMany(config('vodeamanager.models.role_user'));
    }

    public function roleUser() {
        return $this->hasOne(config('vodeamanager.models.role_user'))
            ->whereDate('role_users.valid_from', '<=', Carbon::now()->toDateString())
            ->orderByDesc('role_users.valid_from');
    }

    public function permissions($date = null) {
        if (is_null($date)) {
            $date = Carbon::now()->toDateString();
        }

        $gateSettingIds = config('vodeamanager.models.gate_setting')::select('gate_settings.id')
            ->where('gate_settings.user_id', $this->id)
            ->where('gate_settings.valid_from', '<=', $date)
            ->orderByDesc('gate_settings.valid_from')
            ->limit(1)
            ->pluck('id')
            ->toArray();

        if (empty($gateSettingIds)) {
            $role = $this->roleUser()->exists() ? $this->roleUser->role : null;

            $roleChildrenIds = [];
            if (!empty($role)) {
                if ($role->is_special) {
                    return config('vodeamanager.models.permission')::query();
                }

                $roleChildrenIds = $role->children_ids;
            }

            $gateSettingIds = config('vodeamanager.models.gate_setting')::select('gate_settings.id')
                ->whereIn('gate_settings.role_id', $roleChildrenIds)
                ->where('gate_settings.valid_from', '<=', $date)
                ->orderByDesc('gate_settings.valid_from')
                ->pluck('id')
                ->toArray();
        }

        $permissionIds = config('vodeamanager.models.gate_setting_permission')::select('gate_setting_permissions.permission_id')
            ->whereHas('gateSetting', function ($query) use ($gateSettingIds) {
                $query->whereIn('gate_settings.id', $gateSettingIds);
            })->distinct()->pluck('gate_setting_permissions.permission_id')->toArray();

        return config('vodeamanager.models.permission')::whereIn('id', $permissionIds);
    }

    public function authorized($action) {
        return $this->permissions()->where('permissions.name', $action)->exists();
    }

    public function setValidationRules(array $request = [], $id = null)
    {
        $this->validationRules['email'] ='required|email|unique:users,email,' . ($id ?? 'NULL') . ',id';

        return $this;
    }

    public function getPermissionsAttribute()
    {
        return $this->permissions()->pluck('permissions.name')->toArray();
    }
}

