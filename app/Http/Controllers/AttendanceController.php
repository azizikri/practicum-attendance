<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Helpers\TokenHelper;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function store(string $token, User $assistant, Schedule $schedule)
    {
        /** @var \App\Models\User $user **/
        $user = auth()->user();
        if (! $user->isStudent()) {
            return back()->with('error', 'Kamu bukan praktikan!');
        }

        $isStudentInClass = $user->whereBelongsTo($schedule->class, 'class')->exist();
        if(!$isStudentInClass){
            return back()->with('error', 'Kamu bukan murid dari kelas ini!');
        }

        $isExist = Attendance::where('schedule_id', $schedule->id)
            ->where('student_id', Auth::id())
            ->where('session', $schedule->session)
            ->exists();
        if ($isExist){
            return redirect()->route('dashboard')->with('error', 'Presensi kamu sudah tersimpan!');
        }

        if (TokenHelper::validateToken($token)) {
            Attendance::create([
                'schedule_id' => $schedule->id,
                'assistant_id' => $assistant->id,
                'student_id' => Auth::id(),
                'schedule_class_subject_name' => $schedule->class_subject_name,
                'session' => $schedule->session,
                'assistant_name' => $assistant->name,
                'student_name' => Auth::user()->name,
                'student_npm' => Auth::user()->npm,
            ]);

            return redirect()->route('dashboard')->with('success', 'Presensi berhasil di simpan!');
        } else {
            return redirect()->route('dashboard')->with('error', 'QR sudah expired!');
        }
    }
}
