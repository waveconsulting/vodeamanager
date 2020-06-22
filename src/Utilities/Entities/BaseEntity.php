<?php

namespace Vodeamanager\Core\Utilities\Entities;

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

abstract class BaseEntity extends Model implements Auditable
{
    use SoftDeletes, Userstamps, SearchableCustomTrait, EntityFormRequest, AudibleTrait, ResourceTrait;

    public function scopeCriteria($query, Request $request) {
        $order = null;
        $sorted = null;

        if ($request->has('order_by')) {
            $sorted = in_array(strtolower($request->get('sorted_by')), ['desc', 'descending']) ? 'desc' : 'asc';
            $order = $request->get('order_by');
        } else if (config('vodeamanager.entity.sorting_default.active', false)) {
            $order = config('vodeamanager.entity.sorting_default.column', 'id');
            $sorted = config('vodeamanager.entity.sorting_default.order', 'desc') == 'desc' ? 'desc' : 'asc';
        }

        $query->when($order && $sorted && Schema::hasColumn($this->getTable(),$order), function ($query) use ($order, $sorted) {
            $query->orderBy($order, $sorted);
        });
    }

    public function scopeFilter($query, Request $request)
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

    // todo: can update by relation
    public function getCanUpdateAttribute() {
        return true;
    }

    // todo: create validation can delete by relation
    public function getCanDeleteAttribute() {
        return true;
    }

}
