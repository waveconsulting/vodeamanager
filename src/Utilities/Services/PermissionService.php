<?php

namespace Vodeamanager\Core\Utilities\Services;

class PermissionService
{
   /* public function permissions($user = null, $date = null) {
        if (!$date) {
            $date = now()->toDateString();
        }

        $gateSettingIds = GateSetting::select('gate_settings.id')
            ->where('gate_settings.user_id', $this->id)
            ->where('gate_settings.valid_from', '<=', $date)
            ->orderByDesc('gate_settings.valid_from')
            ->pluck('id')
            ->toArray();

        if (count($gateSettingIds) < 1) {
            $role = $this->role;

            if (empty($role)) {
                return [];
            } else if ($role->is_special) {
                return Permission::all();
            }

            $roleChildrenIds = $role->children_ids;

            $gateSettingIds = GateSetting::select('gate_settings.id')
                ->whereIn('gate_settings.role_id', $roleChildrenIds)
                ->where('gate_settings.valid_from', '<=', $date)
                ->orderByDesc('gate_settings.valid_from')
                ->pluck('id')
                ->toArray();
        }

        if (count($gateSettingIds) < 1) {
            return [];
        }

        return Permission::whereHas('gateSetting', function ($query) use ($gateSettingIds) {
            $query->whereIn('gate_settings.id', $gateSettingIds);
        })->get();
    }*/
}
