<?php

namespace Vodeamanager\Core\Utilities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Ramsey\Uuid\Uuid;
use Vodeamanager\Core\Utilities\Traits\WithAbility;
use Vodeamanager\Core\Utilities\Traits\WithModelValidation;
use Vodeamanager\Core\Utilities\Traits\WithResource;
use Vodeamanager\Core\Utilities\Traits\WithScope;
use Vodeamanager\Core\Utilities\Traits\WithSearchable;
use Wildside\Userstamps\Userstamps;

abstract class BaseModelUuid extends Model implements Auditable
{
    use SoftDeletes,
        Userstamps,
        AudibleTrait,
        WithSearchable,
        WithModelValidation,
        WithResource,
        WithScope,
        WithAbility;

    public $incrementing = false;

    public $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function (self $data) {
            $data->id = Uuid::uuid4();
        });
    }

    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $localKey = $localKey ?: $this->getKeyName();

        return new HasManySyncable(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey
        );
    }
}
