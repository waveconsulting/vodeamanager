<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class MustBeTrue implements Rule
{
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param $val
     * @param string $message
     */
    public function __construct($message = 'The :attribute must be true.')
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
        return $value;
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
