<?php

namespace Vodeamanager\Core\Listeners;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Restoring
{
    /**
     * When the model is being restored.
     *
     * @param Model $model
     * @return void
     */
    public function handle(Model $model)
    {
        if (!$model->isUserStamping() || Auth::check()) {
            return;
        }

        if (!is_null($model->getDeletedByColumn())) {
            $model->{$model->getDeletedByColumn()} = null;
        }
    }
}
