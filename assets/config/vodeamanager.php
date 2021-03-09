<?php

return [
    // decode every query search param
    'decode_search' => true,

    // https://github.com/nicolaslopezj/searchable#entire-text-search
    'search_relevance_default' => [null, true],

    // model register book
    'models' => [
        'user' => config('auth.providers.users.model'),
        'role' => Vodeamanager\Core\Models\Role::class,
        'role_user' => Vodeamanager\Core\Models\RoleUser::class,
        'permission' => Vodeamanager\Core\Models\Permission::class,
        'gate_setting' => Vodeamanager\Core\Models\GateSetting::class,
        'gate_setting_permission' => Vodeamanager\Core\Models\GateSettingPermission::class,
        'setting' => Vodeamanager\Core\Models\Setting::class,
        'media' => Vodeamanager\Core\Models\Media::class,
        'media_use' => Vodeamanager\Core\Models\MediaUse::class,
        'number_setting' => Vodeamanager\Core\Models\NumberSetting::class,
        'number_setting_component' => Vodeamanager\Core\Models\NumberSettingComponent::class,
        'login_activity' => Vodeamanager\Core\Models\LoginActivity::class,
    ]
];
