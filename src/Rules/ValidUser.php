<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidUser implements Rule
{
    protected $request;
    protected $message = 'The selected user is invalid.';

    /**
     * Create a new rule instance.
     *
     * @param array $request
     */
    public function __construct(array $request = [])
    {
        $this->request = $request;
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
        return config('vodeamanager.models.user')::where('id', $value)->exists();
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
