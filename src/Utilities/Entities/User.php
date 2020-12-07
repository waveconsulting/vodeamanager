<?php

namespace Vodeamanager\Core\Utilities\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vodeamanager\Core\Http\Resources\BaseResource;
use Vodeamanager\Core\Rules\NotPresent;
use Vodeamanager\Core\Utilities\Traits\EntityFormRequest;
use Vodeamanager\Core\Utilities\Traits\SearchableCustomTrait;
use Wildside\Userstamps\Userstamps;

abstract class User extends Authenticatable implements Auditable
{
    use Notifiable, SoftDeletes, Userstamps, HasApiTokens, SearchableCustomTrait, EntityFormRequest, AudibleTrait;

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

    public function scopeCriteria($query, Request $request) {
        $order = null;
        $sorted = null;

        if ($request->has('order_by')) {
            $sorted = in_array(strtolower($request->get('sorted_by')), ['desc', 'descending']) ? 'desc' : 'asc';
            $order = $request->get('order_by');
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

    public function getDefaultRules()
    {
        $rules = [];

        foreach ($this->getFillable() as $field) {
            $rules[$field] = [ new NotPresent() ];
        }

        return $rules;
    }

    public function getLabel()
    {
        return $this->name;
    }

    public function getCanUpdateAttribute()
    {
        return true;
    }

    public function getCanDeleteAttribute()
    {
        return true;
    }

}
