<?php

namespace Vodeamanager\Core\Entities;

use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class MediaUse extends BaseEntity
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
