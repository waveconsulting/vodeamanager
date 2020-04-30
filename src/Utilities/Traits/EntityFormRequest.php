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
    protected $rules = [];

    /**
     * Default Messages for Request Form
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Default Properties for Request Form
     *
     * @var array
     */
    protected $properties = [];

    public function getDefaultRules() {
        $rules = [];

        foreach ($this->getFillable() as $field) {
            $rules[$field] = [ new NotPresent() ];
        }

        return $rules;
    }

    public function assignNotPresent() {
        foreach ($this->getFillable() as $field) {
            if (!array_key_exists($field,$this->rules)) {
                $this->rules[$field] = [ new NotPresent() ];
            }
        }
    }

    public function assignChildRules(string $prop, array $nullableFields = []) {
        $rules = [];

        foreach ($this->rules as $key => $rule) {
            if (in_array($key,$nullableFields)) {
                $rules[$prop . '.*.' . $key] = ['nullable'];
            } else {
                $rules[$prop . '.*.' . $key] = $rule;
            }
        }

        $this->rules = $rules;
    }

    public function assignChildMessages(string $prop) {
        $messages = [];

        foreach ($this->messages as $key => $message) {
            $messages[$prop . '.*.' . $key] = $message;
        }

        $this->rules = $messages;
    }

    public function assignChildProperties(string $prop) {
        $properties = [];

        foreach ($this->properties as $key => $property) {
            $properties[$prop . '.*.' . $key] = $property;
        }

        $this->properties = $properties;
    }

    public function getRules() {
        return $this->rules;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getProperties() {
        return $this->properties;
    }

    public function setRules(array $request = []) {}

    public function setMessages(array $request = []) {}

    public function setProperties(array $request = []) {}

}
