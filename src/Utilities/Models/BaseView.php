<?php

namespace Vodeamanager\Core\Utilities\Models;

use Illuminate\Database\Eloquent\Model;
use Vodeamanager\Core\Utilities\Traits\WithLabel;
use Vodeamanager\Core\Utilities\Traits\WithResource;
use Vodeamanager\Core\Utilities\Traits\WithScope;
use Vodeamanager\Core\Utilities\Traits\WithSearchable;

abstract class BaseView extends Model
{
    use WithSearchable, WithScope, WithLabel, WithResource;
}
