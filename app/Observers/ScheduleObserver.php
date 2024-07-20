<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Schedule;
use App\Models\ClassSubject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleObserver
{
    public function creating(Schedule $schedule) : void
    {
        $isConflict = Schedule::where('academic_year', $schedule->academic_year)
            ->where('academic_period', $schedule->academic_period)
            ->where('shift', $schedule->shift)
            ->where('location', $schedule->location)
            ->exists();

        if ($isConflict) {
            $validator = Validator::make([], []);
            $validator->errors()->add('schedule', "The schedule is conflicted.");
            throw new ValidationException($validator, redirect()->back()->withErrors($validator)->withInput());
        }

        $class_subject = ClassSubject::find($schedule->class_subject_id);
        $pj = User::find($schedule->pj_id);

        $classSubjectName = $class_subject->class_name . ' - ' . $class_subject->subject_name;
        $pjName = $pj->name;

        $schedule->class_subject_name = $classSubjectName;
        $schedule->pj_name = $pjName;
    }

    /**
     * Handle the Schedule "updated" event.
     */
    public function updating(Schedule $schedule) : void
    {
        // Check for schedule conflicts excluding the current schedule's ID
        $isConflict = Schedule::where('academic_year', $schedule->academic_year)
            ->where('academic_period', $schedule->academic_period)
            ->where('shift', $schedule->shift)
            ->where('location', $schedule->location)
            ->where('id', '!=', $schedule->id)
            ->exists();

        if ($isConflict) {
            $validator = Validator::make([], []);
            $validator->errors()->add('schedule', "The schedule is conflicted.");
            throw new ValidationException($validator, redirect()->back()->withErrors($validator)->withInput());
        }

        // Update the class_subject_name and pj_name if they have changed
        $newClassSubjectName = $schedule->classSubject->class_name . ' - ' . $schedule->classSubject->subject_name;
        $newPjName = $schedule->pj->name;

        if ($newClassSubjectName != $schedule->class_subject_name) {
            $schedule->class_subject_name = $newClassSubjectName;
        }

        if ($newPjName != $schedule->pj_name) {
            $schedule->pj_name = $newPjName;
        }
    }
}
