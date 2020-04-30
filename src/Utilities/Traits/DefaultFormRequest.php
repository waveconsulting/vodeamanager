<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Illuminate\Support\Arr;

trait DefaultFormRequest
{
    public function rules() {
        return $this->getRules();
    }

    public function messages() {
        return $this->getMessages();
    }

    public function attributes() {
        return $this->getAttributes();
    }

    public function getRules() {
        $className = Arr::last(explode('\\',get_class($this)));
        $nameSpace = "App\\Entities\\" . preg_replace('/(CreateRequest|UpdateRequest)/','',$className);
        $model = app($nameSpace);

        $model->setValidationRules($this->all(), @$this->id);

        return $model->getValidationRules();
    }

    public function getMessages() {
        $className = Arr::last(explode('\\',get_class($this)));
        $nameSpace = "App\\Entities\\" . preg_replace('/(CreateRequest|UpdateRequest)/','',$className);
        $model = app($nameSpace);

        $model->setValidationMessages($this->all(), @$this->id);

        return $model->getValidationMessages();
    }

    public function getAttributes() {
        $className = Arr::last(explode('\\',get_class($this)));
        $nameSpace = "App\\Entities\\" . preg_replace('/(CreateRequest|UpdateRequest)/','',$className);
        $model = app($nameSpace);

        $model->setValidationProperties($this->all(), @$this->id);

        return $model->getValidationPropereties();
    }
}
