<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Vodeamanager\Core\Http\Resources\BaseResource;

trait WithResource
{
    protected $indexResource = BaseResource::class;
    protected $showResource = BaseResource::class;
    protected $selectResource = BaseResource::class;
    protected $relationResource = BaseResource::class;

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

    public function getRelationResource()
    {
        return $this->relationResource;
    }
}
