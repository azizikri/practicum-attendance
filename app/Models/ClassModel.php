<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $guarded = ['id'];
    protected $fillable = ['name'];

    /**
     * Get all of the subjects for the Class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects() : BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'subject_id')
            ->withPivot('class_name', 'subject_name', 'subject_short_name')
            ->withTimestamps();
    }

    public function students() : HasMany
    {
        return $this->hasMany(User::class, 'class_id');
    }


    public function schedules()
    {
        return $this->hasManyThrough(
            Schedule::class,
            ClassSubject::class,
            'class_id',
            'class_subject_id',
            'id'
        );
    }
}
