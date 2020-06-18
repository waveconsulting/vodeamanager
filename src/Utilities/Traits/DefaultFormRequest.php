<?php

namespace Vodeamanager\Core\Utilities\Traits;

trait DefaultFormRequest
{
    protected $entityNamespace = 'App\\Entities\\';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return $this->getRules();
    }

    public function messages()
    {
        return $this->getMessages();
    }

    public function attributes()
    {
        return $this->getAttributes();
    }

    public function getRules()
    {
        $nameSpace = $this->entityNamespace . preg_replace('/(CreateRequest|UpdateRequest)/','',class_basename($this));
        $model = app($nameSpace);

        if (@$this->id) return $model->setValidationRules($this->all(), $this->id)->setExceptUpdateFields()->getValidationRules();

        return $model->setValidationRules($this->all())->getValidationRules();
    }

    public function getMessages()
    {
        $nameSpace = $this->entityNamespace . preg_replace('/(CreateRequest|UpdateRequest)/','',class_basename($this));
        $model = app($nameSpace);

        return $model->setValidationMessages($this->all(), @$this->id)->getValidationMessages();
    }

    public function getAttributes()
    {
        $nameSpace = $this->entityNamespace . preg_replace('/(CreateRequest|UpdateRequest)/','',class_basename($this));
        $model = app($nameSpace);

        return $model->setValidationAttributes($this->all(), @$this->id)->getValidationAttributes();
    }
}
