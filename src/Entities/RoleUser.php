<?php

namespace Vodeamanager\Core\Entities;

use Illuminate\Support\Carbon;
use Vodeamanager\Core\Http\Resources\RoleUserResource;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class RoleUser extends BaseEntity
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->indexResource = $this->showResource = $this->selectResource = RoleUserResource::class;
    }

    protected $fillable = [
        'role_id',
        'user_id',
        'valid_from',
    ];

    protected $dates = [
        'valid_from',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            if (is_null($data->valid_from)) $data->valid_from = Carbon::now();
        });
    }

    public function user()
    {
        return $this->belongsTo(config('vodeamanager.models.user'));
    }

    public function role()
    {
        return $this->belongsTo(config('vodeamanager.models.role'));
    }

}
