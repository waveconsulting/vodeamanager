<?php

namespace Vodeamanager\Core\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserStampScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder;
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param Builder $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        $builder->macro('updateWithUserstamps', function (Builder $builder, $values) {
            if ($builder->getModel()->isUserStamping() && Auth::check()) {
                $values[$builder->getModel()->getUpdatedByColumn()] = Auth::id();
            }

            return $builder->update($values);
        });

        $builder->macro('deleteWithUserstamps', function (Builder $builder) {
            if ($builder->getModel()->isUserStamping() && Auth::check()) {
                $builder->update([
                    $builder->getModel()->getDeletedByColumn() => Auth::id(),
                ]);
            }

            return $builder->delete();
        });
    }
}
