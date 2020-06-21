<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Vodeamanager\Core\Utilities\Constant;

class ValidNumberSettingComponent implements Rule
{
    protected $message;

    /**
     * Create a new rule instance.
     * @param string $message
     */
    public function __construct(string $message = 'The :attribute is invalid.')
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
        if (!is_array($value) || empty($value)) {
            return false;
        }

        $numberSettingComponents = collect($value);
        if ($numberSettingComponents->where('type', Constant::NUMBER_SETTING_COMPONENT_TYPE_COUNTER)->count() > 1) {
            $this->message = 'The :attribute only allowed one type counter.';
            return false;
        }

        return true;
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
