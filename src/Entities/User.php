<?php

namespace Vodeamanager\Core\Entities;

use Illuminate\Support\Carbon;
use Vodeamanager\Core\Http\Resources\UserResource;
use Vodeamanager\Core\Utilities\Entities\User as Authenticatable;

class User extends Authenticatable
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->indexResource = $this->showResource = $this->selectResource = UserResource::class;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'mobile_phone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $validationRules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|max:255',
        'telephone' => 'nullable|string|max:15',
        'mobile_phone' => 'nullable|string|max:15',
        'photo_id' => 'nullable|exists:file_logs,id,deleted_at,NULL',
    ];

    public function photo() {
        return $this->belongsTo(config('vodeamanager.models.file_log'),'photo_id');
    }

    public function roles() {
        return $this->belongsToMany(config('vodeamanager.models.role'), 'role_users')->withTimestamps();
    }

    public function roleUsers() {
        return $this->hasMany(config('vodeamanager.models.role_user'));
    }

    public function roleUser() {
        return $this->hasOne(config('vodeamanager.models.role_user'))
            ->whereDate('role_users.valid_from', '<=', today())
            ->orderByDesc('role_users.valid_from');
    }

    public function permissions($date = null) {
        if (is_null($date)) $date = Carbon::now()->toDateString();

        $gateSettingIds = config('vodeamanager.models.gate_setting')::select('gate_settings.id')
            ->where('gate_settings.user_id', $this->id)
            ->where('gate_settings.valid_from', '<=', $date)
            ->orderByDesc('gate_settings.valid_from')
            ->pluck('id')
            ->toArray();

        if (empty($gateSettingIds)) {
            $role = $this->roleUser()->exists() ? $this->roleUser->role : null;

            if ($role && $role->is_special) return config('vodeamanager.models.permission')::query();

            $roleChildrenIds = $role ? $role->children_ids : [];

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

}

