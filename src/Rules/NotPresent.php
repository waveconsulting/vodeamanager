<?php

namespace Vodea\Vodeamanager\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotPresent implements Rule
{
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param string $message
     */
    public function __construct($message = null)
    {
        $this->message = $message ?? __('The :attribute must not be present.');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
