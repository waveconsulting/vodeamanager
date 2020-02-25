<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotPresent implements Rule
{
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param string $message
     */
    public function __construct($message = 'The :attribute must not be present.')
    {
        $this->message = $message;
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
        return __($this->message);
    }
}
