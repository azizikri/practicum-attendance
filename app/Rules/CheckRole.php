<?php

namespace App\Rules;

use Closure;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckRole implements ValidationRule
{
    public function __construct(
        protected string $role,
    ) {
        if (UserRole::coerce($role) == null) {
            throw new \InvalidArgumentException("Cannot validate against the role, role {$this->role} doesn't exist.");
        }
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $user = User::find($value);

        if ($user && $user->role != $this->role) {
            $fail('The :attribute must be a '. $this->role . '!');
        }
    }
}
