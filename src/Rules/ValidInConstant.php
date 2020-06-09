<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidInConstant implements Rule
{
    protected $constant;
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param array $constant
     * @param string|null $message
     */
    public function __construct(array $constant, string $message = null)
    {
        $this->constant = $constant;
        $this->message = $message ?? 'The selected :attribute must be in ' . implode(array_values($constant), ', ') . '.';
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
        return array_key_exists($value, $this->constant);
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
