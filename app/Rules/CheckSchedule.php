<?php

namespace App\Rules;

use App\Models\Schedule;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckSchedule implements ValidationRule
{
    protected $currentSchedule;

    public function __construct($currentSchedule = null)
    {
        $this->currentSchedule = $currentSchedule;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $academicYear = settings()->get('academic_year');
        $academicPeriod = settings()->get('academic_period');

        $query = Schedule::where('class_subject_id', $value)
            ->where('academic_year', $academicYear)
            ->where('academic_period', $academicPeriod);

        // Ignore the current schedule if it's being updated
        if ($this->currentSchedule) {
            $query->where('id', '!=', $this->currentSchedule->id);
        }

        if ($query->exists()) {
            $fail('The :attribute already has a schedule in this academic year and period!');
        }
    }
}
