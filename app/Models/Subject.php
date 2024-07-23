<?php

namespace App\Models;

use App\Observers\SubjectObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([SubjectObserver::class])]
class Subject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['name', 'short_name'];

    /**
     * Get all of the classSubjects for the Class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function classes() : BelongsToMany
    {
        return $this->belongsToMany(ClassModel::class, 'class_subject', 'subject_id', 'class_id')
            ->withPivot('class_name', 'subject_name', 'subject_short_name')
            ->withTimestamps();
    }


    public function schedules()
    {
        return $this->hasManyThrough(
            Schedule::class,
            ClassSubject::class,
            'subject_id',
            'class_subject_id',
        'id');
    }

    public function currentScheduleId()
    {

        $schedule = $this->schedules()
            ->where('academic_year', settings()->get('academic_year'))
            ->where('academic_period', settings()->get('academic_period'))
            ->first();

        return $schedule ? $schedule->id : null;
    }


    public static function generateShortName($name)
    {
        $words = explode(' ', $name);

        if (count($words) == 1) {
            return $name;
        }

        $shortName = '';
        foreach ($words as $word) {
            if (ctype_digit($word[0])) {
                $shortName .= $word;
            } else {
                foreach (str_split($word) as $char) {
                    if (ctype_upper($char) || ctype_digit($char)) {
                        $shortName .= $char;
                        break;
                    }
                }
            }
        }

        return $shortName;
    }


}
