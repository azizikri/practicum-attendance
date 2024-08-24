<?php

namespace App\Models;

use App\Observers\ScheduleObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([ScheduleObserver::class])]
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
        'academic_period',
        'location',
        'day',
        'shift',
        'session',
        'total_session'
    ];

    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class, 'class_subject_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function studentAttendances(User $user)
    {
        return $this->attendances()->where('user_id', $user->id)->get();
    }

    public function checkAttendances(User $user)
    {
        $attendedSessions = $this->attendances()
            ->where('student_id', $user->id)
            ->whereBetween('session', [1, $this->total_session]) // Mengasumsikan nilai sesi dimulai dari 1
            ->get(['session', 'assistant_name', 'created_at'])
            ->keyBy('session')
            ->toArray();

        $attendanceStatus = [];

        for ($session = 1; $session <= $this->total_session; $session++) {
            if (isset($attendedSessions[$session])) {
                $attendanceStatus[$session] = [
                    'status' => "Hadir",
                    'assistant_name' => $attendedSessions[$session]['assistant_name'],
                    'created_at' => $attendedSessions[$session]['created_at'],
                ];
            } else {
                $attendanceStatus[$session] = [
                    'status' => "Absen",
                    'assistant_name' => "Tidak ada Data",
                    'created_at' => "Tidak ada Data",
                ];
            }
        }

        return $attendanceStatus;
    }



    public function pj()
    {
        return $this->belongsTo(User::class, 'pj_id');
    }

    public function assistants() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function students()
    {
        return $this->belongsToThrough(User::class, [ClassSubject::class, ClassModel::class]);
    }

    public function class()
    {
        return $this->belongsToThrough(ClassModel::class, ClassSubject::class);
    }
}
