<?php

return [
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
        'notification_type' => Vodeamanager\Core\Entities\NotificationType::class,
        'notification' => Vodeamanager\Core\Entities\Notification::class,
        'notification_message' => Vodeamanager\Core\Entities\NotificationMessage::class,
        'notification_user' => Vodeamanager\Core\Entities\NotificationUser::class,
    ],
    'views' => [
        'role_subordinates' => \Vodeamanager\Core\Entities\Views\RoleSubordinate::class,
    ]
];
