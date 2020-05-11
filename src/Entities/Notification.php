<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Notification extends BaseEntity
{
    protected $fillable = [
        'notification_type_id',

    ];

    public function notificationType() {
        return $this->belongsTo(config('vodeamanager.models.notification_type'));
    }

    public function notificationUsers() {
        return $this->hasMany(config('vodeamanager.models.notification_user'));
    }

    public function notificationMessages() {
        return $this->hasMany(config('vodeamanager.models.notification_message'));
    }

    public function users() {
        return $this->belongsToMany(config('vodeamanager.models.user'), 'notification_users')->withTimestamps();
    }

}
