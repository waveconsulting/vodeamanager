<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Notification extends BaseEntity
{
    protected $fillable = [
        'notification_type_id',
        'data',
    ];

    protected $casts = [
        'data' => 'object',
    ];

    public function notificationType()
    {
        return $this->belongsTo(config('vodeamanager.models.notification_type'));
    }

    public function notificationUsers()
    {
        return $this->hasMany(config('vodeamanager.models.notification_user'));
    }

}
