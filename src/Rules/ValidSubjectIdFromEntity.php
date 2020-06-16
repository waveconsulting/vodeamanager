<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ValidSubjectIdFromEntity implements Rule
{
    protected $request;
    protected $message = 'The selected :attribute is invalid.';

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
        if (!$entity = Arr::get($this->request, 'entity')) return false;
        if (!class_exists($entity)) return false;

        return app($entity)::find($value);
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
