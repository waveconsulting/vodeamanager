<?php

namespace Vodeamanager\Core\Listeners;

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
        if (!$model->isUserStamping() || !Auth::check()) {
            return;
        }

        if (!is_null($model->getUpdatedByColumn())) {
            $model->{$model->getUpdatedByColumn()} = Auth::id();
        }
    }
}
