<?php

namespace Vodeamanager\Core\Utilities\Traits;

trait WithForceGenerateUuid
{
    protected $forceGenerateUuid = true;

    public function getForceGenerateUuid()
    {
        return $this->forceGenerateUuid;
    }
}
