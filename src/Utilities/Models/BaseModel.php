<?php

namespace Vodeamanager\Core\Utilities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vodeamanager\Core\Http\Resources\BaseResource;
use Vodeamanager\Core\Utilities\Traits\WithAbility;
use Vodeamanager\Core\Utilities\Traits\WithLabel;
use Vodeamanager\Core\Utilities\Traits\WithModelValidation;
use Vodeamanager\Core\Utilities\Traits\WithScope;
use Vodeamanager\Core\Utilities\Traits\WithSearchable;
use Wildside\Userstamps\Userstamps;

abstract class BaseModel extends Model implements Auditable
{
    use SoftDeletes,
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

    public function getResource()
    {
        return $this->indexResource;
    }

    public function getShowResource()
    {
        return $this->showResource;
    }

    public function getSelectResource()
    {
        return $this->selectResource;
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
