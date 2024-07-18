<?php

namespace App\Rules;

use Closure;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckRoleStudent implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $student = User::find($value);

        if($student && $student->role != UserRole::Student)
        {
            $fail('The :attribute must be a Student!');
        }
    }
}
