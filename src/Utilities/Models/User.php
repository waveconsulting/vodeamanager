<?php

namespace Vodeamanager\Core\Utilities\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use OwenIt\Auditing\Auditable as AudibleTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Vodeamanager\Core\Rules\NotPresent;
use Vodeamanager\Core\Utilities\Traits\WithAbility;
use Vodeamanager\Core\Utilities\Traits\WithHasManySyncable;
use Vodeamanager\Core\Utilities\Traits\WithModelValidation;
use Vodeamanager\Core\Utilities\Traits\WithResource;
use Vodeamanager\Core\Utilities\Traits\WithScope;
use Vodeamanager\Core\Utilities\Traits\WithSearchable;
use Wildside\Userstamps\Userstamps;

abstract class User extends Authenticatable implements Auditable
{
    use Notifiable,
        SoftDeletes,
        Userstamps,
        WithSearchable,
        WithModelValidation,
        AudibleTrait,
        WithResource,
        WithScope,
        WithAbility,
        WithHasManySyncable;
}
