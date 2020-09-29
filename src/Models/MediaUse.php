<?php

namespace Vodeamanager\Core\Models;

use Vodeamanager\Core\Utilities\Models\BaseModel;

class MediaUse extends BaseModel
{
    protected $fillable = [
        'media_id',
        'entity',
        'subject_id',
    ];

    public function media()
    {
        return $this->belongsTo(config('vodeamanager.models.media'));
    }

    public function subject()
    {
        return $this->morphTo(__FUNCTION__, 'entity', 'subject_id');
    }

}
