<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckScheduleSession implements ValidationRule
{
    protected $currentSchedule;

    public function __construct($currentSchedule)
    {
        $this->currentSchedule = $currentSchedule;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->currentSchedule->total_session < $value){
            $fail('The :attribute is already ended!');
        }
    }
}
