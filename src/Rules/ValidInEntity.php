<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidInEntity implements Rule
{
    protected $model;
    protected $column;
    protected $message = 'The selected :attribute is invalid.';

    /**
     * Create a new rule instance.
     * @param string $model
     * @param string $column
     */
    public function __construct(string $model, string $column = 'id')
    {
        $this->model = $model;
        $this->column = $column;
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
        return app($this->model)->where($this->column, $value)->exists();
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
