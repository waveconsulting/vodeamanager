<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class RoleUser extends BaseEntity
{
    protected $fillable = [
        'role_id',
        'user_id',
        'valid_from',
    ];

    protected static function boot()
    {
        static::creating(function ($data) {
            if (!$data->valid_from) {
                $data->valid_from = now();
            }
        });
    }

    public function user() {
        return $this->belongsTo(config('vodeamanager.models.user'));
    }

    public function role() {
        return $this->belongsTo(config('vodeamanager.models.role'));
    }

}
