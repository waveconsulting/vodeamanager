<?php

namespace Vodeamanager\Core\Utilities\Services;

use Illuminate\Database\Eloquent\Model;

class MediaService
{
    /**
     * File log usages
     *
     * @param Model $model
     * @param string $relationName
     *
     * @return void
     */
    public function logUse(Model $model, string $relationName) {
        try {
            if ($attachment = $model->$relationName) {
                $logUse = [
                    'entity' => get_class($model),
                    'subject_id' => $model->id
                ];

                if (!$attachment->mediaUses()->where($logUse)->exists()) {
                    $attachment->mediaUses()->create($logUse);
                }
            }
        } catch (\Exception $e) {
            \Vodeamanager\Core\Utilities\Facades\ExceptionService::log($e);
        }
    }
}
