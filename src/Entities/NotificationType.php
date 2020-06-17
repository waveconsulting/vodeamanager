<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Http\Resources\NotificationTypeResource;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class NotificationType extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        $this->indexResource = $this->showResource = $this->selectResource = NotificationTypeResource::class;

        parent::__construct($attributes);
    }

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
