<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Vodeamanager\Core\Utilities\Entities\BaseEntity;

class ValidUnique implements Rule
{
    protected $id;
    protected $model;
    protected $message = 'The :attribute has already been taken.';

    /**
     * Create a new rule instance.
     *
     * @param BaseEntity $model
     * @param null $id
     */
    public function __construct(BaseEntity $model, $id = null)
    {
        $this->model = $model;
        $this->id = $id;
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
        return !$this->model->when($this->id, function ($query) {
            $query->where('id', '!=', $this->id);
        })->where($attribute, $value)->exists();
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
