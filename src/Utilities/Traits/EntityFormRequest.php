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
     * @return void
     */
    public function assignNotPresent() {
        foreach ($this->getFillable() as $field) {
            if (!array_key_exists($field,$this->validationRules)) {
                $this->validationRules[$field] = [ new NotPresent() ];
            }
        }
    }

    /**
     * @param string $attribute
     * @param array $nullableFields
     * @return void
     */
    public function assignChildValidationRules(string $attribute, array $nullableFields = []) {
        $validationRules = [];

        foreach ($this->getValidationRules() as $key => $rule) {
            if (in_array($key,$nullableFields)) {
                $validationRules[$attribute . '.*.' . $key] = ['nullable'];
            } else {
                $validationRules[$attribute . '.*.' . $key] = $rule;
            }
        }

        $this->validationRules = $validationRules;
    }

    /**
     * @param string $attribute
     * @return void
     */
    public function assignChildValidationMessages(string $attribute) {
        $validationMessages = [];

        foreach ($this->getValidationMessages() as $key => $message) {
            $validationMessages[$attribute . '.*.' . $key] = $message;
        }

        $this->validationMessages = $validationMessages;
    }

    /**
     * @param string $attribute
     * @return void;
     */
    public function assignChildValidationAttributes(string $attribute) {
        $validationAttributes = [];

        foreach ($this->getValidationAttributes() as $key => $property) {
            $validationAttributes[$attribute . '.*.' . $key] = $property;
        }

        $this->validationAttributes = $validationAttributes;
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

    /**
     * @param array $request
     * @param null $id
     * @return void
     */
    public function setValidationRules(array $request = [], $id = null) {}

    /**
     * @param array $request
     * @return void;
     */
    public function setValidationMessages(array $request = []) {}

    /**
     * @param array $request
     * @return void;
     */
    public function setValidationAttributes(array $request = []) {}

    /**
     * @param mixed ...$validationRules
     * @return void
     */
    public function mergeValidationRules(...$validationRules) {
        if (is_array($validationRules)) {
            foreach ($validationRules as $validationRule) {
                if (is_array($validationRule)) {
                    $this->validationRules = array_merge($this->validationRules, $validationRule);
                }
            }
        }
    }

    /**
     * @param mixed ...$validationMessages
     * @return void
     */
    public function mergeValidationMessage(...$validationMessages) {
        if (is_array($validationMessages)) {
            foreach ($validationMessages as $validationMessage) {
                if (is_array($validationMessage)) {
                    $this->validationMessages = array_merge($this->validationMessages, $validationMessage);
                }
            }
        }
    }

    /**
     * @param mixed ...$validationAttributes
     * @return void
     */
    public function mergeValidationAttributes(...$validationAttributes) {
        if (is_array($validationAttributes)) {
            foreach ($validationAttributes as $validationAttribute) {
                if (is_array($validationAttribute)) {
                    $this->validationAttributes = array_merge($this->validationAttributes, $validationAttribute);
                }
            }
        }
    }

}
