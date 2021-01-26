<?php

namespace Vodeamanager\Core\Utilities\Traits;

trait WithLabel
{
    protected $labelAttribute = 'name';

    public function getLabel()
    {
        $labelAttribute = $this->labelAttribute;

        return $this->$labelAttribute;
    }
}
