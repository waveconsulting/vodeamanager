<?php

namespace Vodeamanager\Core\Utilities\Traits;

trait DefaultRequest
{
    public function rules() {
        if (method_exists($this, 'defaultRules')) {
            return $this->defaultRules();
        }

        return [];
    }

    public function messages() {
        if (method_exists($this,'defaultMessages')) {
            return $this->defaultMessages();
        }

        return [];
    }

    public function attributes() {
        if (method_exists($this,'defaultAttributes')) {
            return $this->defaultAttributes();
        }

        return [];
    }
}
