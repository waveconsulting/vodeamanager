<?php

namespace Smoothsystem\Core\Listeners;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Updating
{
    /**
     * When the model is being updated.
     *
     * @param Model $model
     * @return void
     */
    public function handle(Model $model)
    {
        if (!$model->isUserStamping() || is_null(Auth::id())) {
            return;
        }

        $model->{$model->getUpdatedByColumn()} = Auth::id();
    }
}
