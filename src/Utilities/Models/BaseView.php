<?php

namespace Vodeamanager\Core\Utilities\Models;

use Illuminate\Database\Eloquent\Model;
use Vodeamanager\Core\Http\Resources\BaseResource;
use Vodeamanager\Core\Utilities\Traits\WithScope;
use Vodeamanager\Core\Utilities\Traits\WithSearchable;

abstract class BaseView extends Model
{
    use WithSearchable, WithScope;

    protected $indexResource = BaseResource::class;
    protected $showResource = BaseResource::class;
    protected $selectResource = BaseResource::class;

    public function getResource()
    {
        return $this->indexResource;
    }

    public function getShowResource()
    {
        return $this->showResource;
    }

    public function getSelectResource()
    {
        return $this->selectResource;
    }

}
