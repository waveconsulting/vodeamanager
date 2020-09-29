<?php

namespace Vodeamanager\Core\Utilities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Vodeamanager\Core\Utilities\Traits\ResourceTrait;
use Vodeamanager\Core\Utilities\Traits\SearchableCustomTrait;

abstract class BaseView extends Model
{
    use SearchableCustomTrait, ResourceTrait;

    public function scopeCriteria($query, Request $request) {
        if ($request->has('order_by')) {
            $sorted = in_array(strtolower($request->get('sorted_by')), ['desc', 'descending']) ? 'desc' : 'asc';
            $order = $request->get('order_by');

            $query->when(Schema::hasColumn($this->getTable(),$order), function ($query) use ($order, $sorted) {
                $query->orderBy($order, $sorted);
            });
        }
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

}
