<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

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
        if (empty($message)) {
            $options = Arr::isAssoc($this->constant) ? array_values($constant) : $this->constant;
            $message = 'The selected :attribute must be in ' . implode(', ', $options) . '.';
        }

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
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        if (Arr::isAssoc($this->constant)) {
            return array_key_exists($value, $this->constant);
        }

        return in_array($value, $this->constant);
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
