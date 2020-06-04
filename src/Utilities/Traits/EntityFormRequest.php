<?php

namespace Vodeamanager\Core\Utilities\Traits;

use Vodeamanager\Core\Rules\NotPresent;

trait EntityFormRequest
{
    /**
     * Default Rules for Request form
     *
     * @var array
     */
    protected $validationRules = [];

    /**
     * Default Messages for Request Form
     *
     * @var array
     */
    protected $validationMessages = [];

    /**
     * Default Properties for Request Form
     *
     * @var array
     */
    protected $validationAttributes = [];

    /**
     * @return array
     */
    public function getDefaultRules() {
        $validationRules = [];

        foreach ($this->getFillable() as $field) {
            $validationRules[$field] = [ new NotPresent() ];
        }

        return $validationRules;
    }

    /**
     * @return EntityFormRequest
     */
    public function assignNotPresent() {
        foreach ($this->getFillable() as $field) {
            if (!array_key_exists($field,$this->validationRules)) $this->validationRules[$field] = [ new NotPresent() ];
        }

        return $this;
    }

    /**
     * @param array $request
     * @param null $id
     * @return EntityFormRequest
     */
    public function setValidationRules(array $request = [], $id = null) {
        return $this;
    }

    /**
     * @param array $request
     * @return EntityFormRequest ;
     */
    public function setValidationMessages(array $request = []) {
        return $this;
    }

    /**
     * @param array $request
     * @return EntityFormRequest
     */
    public function setValidationAttributes(array $request = []) {
        return $this;
    }

    /**
     * @return array
     * @return void
     */
    public function getValidationRules() {
        $this->assignNotPresent();

        return $this->validationRules;
    }

    /**
     * @return array
     */
    public function getValidationMessages() {
        return $this->validationMessages;
    }

    /**
     * @return array
     */
    public function getValidationAttributes() {
        return $this->validationAttributes;
    }

}
