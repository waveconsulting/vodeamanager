<?php

namespace Vodeamanager\Core\Utilities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vodeamanager\Core\Utilities\Traits\EntityFormRequest;
use Vodeamanager\Core\Utilities\Traits\ResourceTrait;
use Vodeamanager\Core\Utilities\Traits\SearchableCustomTrait;
use Wildside\Userstamps\Userstamps;

abstract class BaseModel extends Model implements Auditable
{
    use SoftDeletes, Userstamps, SearchableCustomTrait, EntityFormRequest, AudibleTrait, ResourceTrait;

    public function scopeCriteria($query, Request $request) {
        if ($request->has('order_by')) {
            $sorted = in_array(strtolower($request->get('sorted_by')), ['desc', 'descending']) ? 'desc' : 'asc';
            $order = $request->get('order_by');

            $query->orderBy($order, $sorted);
        }
    }

    public function scopeFilter($query, Request $request)
    {
        //
    }

    public function scopeSubQuery($query, Request $request)
    {
        //
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

    public function getLabel() {
        return $this->name;
    }

    public function getCanUpdateAttribute() {
        return true;
    }

    public function getCanDeleteAttribute() {
        return true;
    }

}
