<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'class_subject_id',
        'pj_id',
        'class_subject_name',
        'pj_name',
        'academic_year',
        'day',
        'shift'
    ];

    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class);
    }

    public function pj()
    {
        return $this->belongsTo(User::class, 'pj_id');
    }

    public function students()
    {
        return $this->belongsToThrough(User::class, [ClassSubject::class, ClassModel::class]);
    }
}
