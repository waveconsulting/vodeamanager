<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class NotificationType extends BaseEntity
{
    protected $fillable = [
        'code',
        'name',
        'icon',
        'hex_color',
    ];

    public function notifications()
    {
        return $this->hasMany(config('vodeamanager.models.notification'));
    }

}
