<?php

namespace Vodeamanager\Core\Utilities\Services;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class FileLogService
{
    public function logUse(BaseEntity $model, string $relationName) {
        if ($attachment = $model->$relationName) {
            $attachment->fileLogUses()->create([
                'entity' => get_class($model),
                'subject_id' => $model->id
            ]);
        }
    }
}
