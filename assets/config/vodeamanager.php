<?php

return [
    'custom_login_activity' => false,
    'entity' => [
        'sorting_default' => [
            'active' => true,
            'column' => 'id',
            'order' => 'desc',
        ],
    ],
    'passport' => [
        'register' => true,
        'custom_routes' => false,
        'expires' => [
            'token' => 15, //days
            'refresh_token' => 30, //days
            'personal_access_token' => 6, //months
        ]
    ],
    'models' => [
        'user' => config('auth.providers.users.model'),
        'role' => Vodeamanager\Core\Entities\Role::class,
        'role_user' => Vodeamanager\Core\Entities\RoleUser::class,
        'permission' => Vodeamanager\Core\Entities\Permission::class,
        'gate_setting' => Vodeamanager\Core\Entities\GateSetting::class,
        'gate_setting_permission' => Vodeamanager\Core\Entities\GateSettingPermission::class,
        'setting' => Vodeamanager\Core\Entities\Setting::class,
        'file_log' => Vodeamanager\Core\Entities\FileLog::class,
        'number_setting' => Vodeamanager\Core\Entities\NumberSetting::class,
        'number_setting_component' => Vodeamanager\Core\Entities\NumberSettingComponent::class,
        'login_activity' => Vodeamanager\Core\Entities\LoginActivity::class,
    ]
];
