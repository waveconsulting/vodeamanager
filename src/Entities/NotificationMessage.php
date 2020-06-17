<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class NotificationMessage extends BaseEntity
{
    protected $fillable = [
        'notification_id',

    ];

    public function notification()
    {
        return $this->belongsTo(config('vodeamanager.models.notification'));
    }

}
