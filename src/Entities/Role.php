<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class Role extends BaseEntity
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'parent_id',
        'is_special',
    ];

    protected $casts = [
        'is_special' => 'boolean',
    ];

    protected $validationRules = [
        'name' => 'required|string|max:255',
        'description' => 'string|max:255',
        'parent_id' => 'exists:roles,id,deleted_at,NULL',
        'is_special' => 'boolean',
    ];

    public function parent() {
        return $this->belongsTo(config('vodeamanager.models.role'))->with('parent');
    }

    public function children() {
        return $this->hasMany(config('vodeamanager.models.role'),'parent_id')->with('children');
    }

    public function roleUsers() {
        return $this->hasMany(config('vodeamanager.models.role_user'));
    }

    public function gateSettings() {
        return $this->hasMany(config('vodeamanager.models.gate_setting'));
    }

    public function users() {
        return $this->belongsToMany(config('vodeamanager.models.user'), 'role_users')->withTimestamps();
    }

    public function getChildrenIdsAttribute() {
        $data = [];

        $this->recursiveChildrenGetAttribute($this, $data);

        return $data;
    }

    public function recursiveChildrenGetAttribute($child, &$data, $key = 'id') {
        array_push($data, $child[$key]);

        if (count($child->children) > 0) {
            foreach ($child->children as $child) {
                $this->recursiveChildrenGetAttribute($child, $data, $key);
            }
        }
    }

    public function setValidationRules(array $request = [], $id = null)
    {
        $this->validationRules['code'] = [
            'required',
            'string',
            'max:24',
            'unique:roles,code,' . ($id ?? 'NULL') . ',id,deleted_at,NULL',
        ];

        return $this;
    }

}
