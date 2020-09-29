<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Carbon;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class RoleUser extends Model implements Auditable
{
    use BaseEntity, AudibleTrait;

    protected $fillable = [
        'role_id',
        'user_id',
        'valid_from',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            if (is_null($data->valid_from)) {
                $data->valid_from = Carbon::now()->toDateString();
            }
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
