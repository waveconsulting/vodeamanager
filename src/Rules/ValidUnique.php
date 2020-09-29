<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ValidUnique implements Rule
{
    protected $id;
    protected $model;
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param $model
     * @param null $id
     * @param string $message
     * @throws BindingResolutionException
     */
    public function __construct($model, $id = null, string $message = 'The :attribute has already been taken.')
    {
        if (is_string($model) && class_exists($model)) {
            $model = Container::getInstance()->make($model);
        }

        if ($model instanceof Model) {
            $this->model = $model;
        }

        $this->id = $id;
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
        if (empty($this->model)) {
            return false;
        }

        $attribute = Arr::last(explode('.',$attribute));

        $query = $this->model->where($attribute, $value);
        if ($this->id) {
            $query = $query->where('id', '!=', $this->id);
        }

        return !$query->exists();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __($this->message)($this->message);
    }
}
