<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassSubject extends Pivot
{
    protected $table = 'class_subject';
    protected $fillable = ['class_id', 'subject_id', 'class_name', 'subject_name'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_subject_id');
    }
}
