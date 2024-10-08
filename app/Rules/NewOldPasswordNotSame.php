<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NewOldPasswordNotSame implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $currentPassword;

    public function __construct($currentPassword)
    {
        $this->currentPassword = $currentPassword;
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
        return $value != $this->currentPassword;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute should not be same with old password.';
    }
}
