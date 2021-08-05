<?php

namespace Vodeamanager\Core\Models;

use Vodeamanager\Core\Utilities\Models\BaseModel;

class BookedNumber extends BaseModel
{
    protected $fillable = [
        'entity',
        'number',
    ];

}
