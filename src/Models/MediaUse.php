<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class MediaUse extends Model
{
    use BaseEntity;

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
