<?php

namespace Vodeamanager\Core\Utilities\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vodeamanager\Core\Rules\NotPresent;
use Vodeamanager\Core\Utilities\Traits\Searchable;
use Vodeamanager\Core\Utilities\Traits\UserStamp;

abstract class BaseEntity extends Model
{
    use SoftDeletes, UserStamp, Searchable;

    /**
     * Columns and their priority in search results.
     * Columns with higher values are more important.
     * Columns with equal values have equal importance.
     ** @var array
     */
    protected $searchable = [
        'columns' => [],
        'joins' => [],
    ];

    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return new HasManySyncable(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey
        );
    }

    public function getDefaultRules() {
        $rules = [];

        foreach ($this->getFillable() as $field) {
            $rules[$field] = [ new NotPresent() ];
        }

        return $rules;
    }

    public function getLabel() {
        return $this->name;
    }

    // todo: create validation can delete by relation
    public function getCanDeleteAttribute() {
        return true;
    }

}
