<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['name'];

    /**
     * Get all of the classSubjects for the Class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function classes() : BelongsToMany
    {
        return $this->belongsToMany(ClassModel::class, 'class_subjects', 'class_id')
            ->withPivot('class_name', 'subject_name')
            ->withTimestamps();

    }

    public function schedules()
    {
        return $this->hasManyThrough(Schedule::class, ClassSubject::class);
    }
}
