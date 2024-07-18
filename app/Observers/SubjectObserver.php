<?php

namespace App\Observers;

use App\Models\Subject;

class SubjectObserver
{
    /**
     * Handle the Subject "created" event.
     */
    public function creating(Subject $subject): void
    {
        $shortName = $subject->generateShortName($subject->name);
        $subject->short_name = $shortName;
    }

    /**
     * Handle the Subject "updated" event.
     */
    public function updating(Subject $subject): void
    {
        $newShortName = $subject->generateShortName($subject->name);

        if ($newShortName != $subject->short_name) {
            $subject->short_name = $newShortName;
        }
    }
}
