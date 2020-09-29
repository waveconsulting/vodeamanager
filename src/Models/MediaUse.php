<?php

namespace Vodeamanager\Core\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vodeamanager\Core\Utilities\Traits\BaseEntity;

class MediaUse extends Model implements Auditable
{
    use BaseEntity, AudibleTrait;

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
