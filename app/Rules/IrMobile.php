<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IrMobile implements Rule
{
    public function passes($attribute, $value)
    {
        if (empty($value))
            return true;
        // return preg_match('/^[9]{1}[0-9]{9}$/u', $value);
        return preg_match('/^([0]{1})?[9]{1}[0-9]{9}$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'شماره موبایل وارد شده معتبر نیست.';
    }
}
