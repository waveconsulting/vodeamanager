<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Vodeamanager\Core\Http\Resources\DefaultResource;
use Vodeamanager\Core\Http\Resources\SelectResource;

trait ResourceTrait
{
    protected $indexResource = DefaultResource::class;
    protected $showResource = DefaultResource::class;
    protected $selectResource = SelectResource::class;

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
