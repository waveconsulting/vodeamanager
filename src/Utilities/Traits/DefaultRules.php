<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Illuminate\Support\Arr;

trait DefaultRules
{
    public function getRules() {
        $className = Arr::last(explode('\\',get_class($this)));
        $nameSpace = "App\\Entities\\" . preg_replace('/(CreateRequest|UpdateRequest)/','',$className);
        $model = app($nameSpace);

        $model->setRules($this->all());

        return $model->getRules();
    }
}
