<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

/**
 * The field under validation may have alpha-numeric characters, as well as
 * hyphen.
 */
class AlphaNumHyphen implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $rule = preg_match('/^[\pL\pM\pN-]+$/u', $value);

        if ($rule === false || $rule === 0) {
            $fail('The :attribute may only contain letters, numbers and hyphens.');
        }
    }
}
