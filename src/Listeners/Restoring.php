<?php

namespace Vodeamanager\Core\Listeners;

use Illuminate\Database\Eloquent\Model;

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
        if (! $model->isUserStamping()) return;

        $model->{$model->getDeletedByColumn()} = null;
    }
}
