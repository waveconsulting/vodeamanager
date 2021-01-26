<?php

namespace Vodeamanager\Core\Utilities\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vodeamanager\Core\Http\Resources\BaseResource;
use Vodeamanager\Core\Utilities\Traits\WithAbility;
use Vodeamanager\Core\Utilities\Traits\WithLabel;
use Vodeamanager\Core\Utilities\Traits\WithModelValidation;
use Vodeamanager\Core\Utilities\Traits\WithScope;
use Vodeamanager\Core\Utilities\Traits\WithSearchable;
use Wildside\Userstamps\Userstamps;

abstract class User extends Authenticatable implements Auditable
{
    use Notifiable,
        SoftDeletes,
        Userstamps,
        AudibleTrait,
        WithLabel,
        WithSearchable,
        WithModelValidation,
        WithScope,
        WithAbility;

    protected $indexResource = BaseResource::class;
    protected $showResource = BaseResource::class;
    protected $selectResource = BaseResource::class;

    public function getResource(): string
    {
        return $this->indexResource;
    }

    public function getShowResource(): string
    {
        return $this->showResource;
    }

    public function getSelectResource(): string
    {
        return $this->selectResource;
    }

    public function hasMany($related, $foreignKey = null, $localKey = null): HasManySyncable
    {
        $instance = $this->newRelatedInstance($related);
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $localKey = $localKey ?: $this->getKeyName();

        return new HasManySyncable(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey
        );
    }
}
