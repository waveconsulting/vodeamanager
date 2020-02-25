<?php

namespace Smoothsystem\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ValidPassword implements Rule
{
    protected $id;
    protected $password;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($password, $id = null)
    {
        $this->id = $id ?? Auth::id();
        $this->password = $password;
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
        $user = config('smoothsystem.models.user')::find($this->id);

        return Hash::check($this->password, $user->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Password is incorrect.');
    }
}
