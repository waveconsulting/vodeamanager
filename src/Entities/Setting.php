<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Http\Resources\SettingResource;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Setting extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        $this->indexResource = $this->showResource = $this->selectResource = SettingResource::class;

        parent::__construct($attributes);
    }

    protected $fillable = [
        'type',
        'data',
    ];

    protected $casts = [
        'data' => 'object',
    ];

}
