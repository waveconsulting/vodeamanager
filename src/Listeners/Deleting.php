<?php

namespace Vodeamanager\Core\Listeners;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Deleting
{
    /**
     * When the model is being deleted.
     *
     * @param Model $model
     * @return void
     */
    public function handle(Model $model)
    {
        if (!$model->isUserStamping() || Auth::check()) {
            return;
        }

        if (is_null($model->{$model->getDeletedByColumn()}) && !is_null($model->getDeletedByColumn())) {
            $model->{$model->getDeletedByColumn()} = Auth::id();
        }

        $dispatcher = $model->getEventDispatcher();

        $model->unsetEventDispatcher();
        $model->save();
        $model->setEventDispatcher($dispatcher);
    }
}
