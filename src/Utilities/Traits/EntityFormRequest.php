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

        foreach ($this->getRules() as $key => $rule) {
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

        foreach ($this->getMessages() as $key => $message) {
            $messages[$prop . '.*.' . $key] = $message;
        }

        $this->rules = $messages;
    }

    public function assignChildProperties(string $prop) {
        $properties = [];

        foreach ($this->getProperties() as $key => $property) {
            $properties[$prop . '.*.' . $key] = $property;
        }

        $this->properties = $properties;
    }

    public function getRules() {
        $this->assignNotPresent();

        return $this->rules;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getProperties() {
        return $this->properties;
    }

    public function setRules(array $request = [], $id = null) {}

    public function setMessages(array $request = []) {}

    public function setProperties(array $request = []) {}

    public function mergeRules(...$rules) {
        foreach ($rules as $rule) {
            if (is_array($rule)) {
                $this->rules = array_merge($this->rules, $rule);
            }
        }
    }

    public function mergeMessages(...$messages) {
        foreach ($messages as $message) {
            if (is_array($message)) {
                $this->messages = array_merge($this->messages, $message);
            }
        }
    }

    public function mergeProperties(...$properties) {
        foreach ($properties as $property) {
            if (is_array($property)) {
                $this->properties = array_merge($this->properties, $property);
            }
        }
    }

}
