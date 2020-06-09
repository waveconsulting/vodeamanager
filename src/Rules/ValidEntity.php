<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ValidEntity implements Rule
{
    protected $request;
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param array $request
     * @param string $message
     */
    public function __construct(array $request = [], $message = 'The selected :attribute is invalid.')
    {
        $this->request = $request;
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
        if (Arr::has($this->request, 'entity')) $value = Arr::get($this->request, 'entity');
        return class_exists($value);
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
