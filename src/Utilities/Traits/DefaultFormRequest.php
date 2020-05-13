<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Illuminate\Support\Arr;

trait DefaultFormRequest
{
    protected $entityNamespace = 'App\\Entities\\';

    public function authorize() {
        return true;
    }

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
        $nameSpace = $this->entityNamespace . preg_replace('/(CreateRequest|UpdateRequest)/','',class_basename($this));
        $model = app($nameSpace);

        $model->setValidationRules($this->all(), @$this->id);

        return $model->getValidationRules();
    }

    public function getMessages() {
        $nameSpace = $this->entityNamespace . preg_replace('/(CreateRequest|UpdateRequest)/','',class_basename($this));
        $model = app($nameSpace);

        $model->setValidationMessages($this->all(), @$this->id);

        return $model->getValidationMessages();
    }

    public function getAttributes() {
        $nameSpace = $this->entityNamespace . preg_replace('/(CreateRequest|UpdateRequest)/','',class_basename($this));
        $model = app($nameSpace);

        $model->setValidationAttributes($this->all(), @$this->id);

        return $model->getValidationAttributes();
    }
}
