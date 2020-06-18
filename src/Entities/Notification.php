<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Http\Resources\NotificationResource;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Notification extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->indexResource = $this->showResource = $this->selectResource = NotificationResource::class;
    }

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

    public function users()
    {
        return $this->belongsToMany(config('vodeamanager.models.user'), 'notification_users')->withTimestamps();
    }

}
