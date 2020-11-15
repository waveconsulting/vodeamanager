<?php

namespace Vodeamanager\Core\Utilities\Traits;

trait WithAbility
{
    public function getCanUpdateAttribute() {
        return true;
    }

    public function getCanDeleteAttribute() {
        return true;
    }
}
