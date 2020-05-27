<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class NotificationUser extends BaseEntity
{
    protected $fillable = [
        'notification_id',
        'user_id',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function notification() {
        return $this->belongsTo(config('vodeamanager.models.notification'));
    }

    public function user() {
        return $this->belongsTo(config('vodeamanager.models.user'));
    }

}
