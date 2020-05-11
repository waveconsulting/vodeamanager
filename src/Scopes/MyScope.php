<?php

namespace Vodeamanager\Core\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class MyScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->when(Auth::check(), function ($query) {
            $query->where('user_id', Auth::id());
        }, function ($query) {
            $query->where('user_id', 0);
        });
    }
}