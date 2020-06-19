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
     * @param $model
     * @param null $id
     */
    public function __construct($model, $id = null)
    {
        $this->id = $id;
        if (is_string($model) && class_exists($model)) $model = app($model);
        if ($model instanceof BaseEntity) $this->model = $model;

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
        if (empty($this->model)) return false;

        $query = $this->model->where($attribute, $value);
        if ($this->id) $query = $query->where('id', '!=', $this->id);

        return !$query->exists();

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
