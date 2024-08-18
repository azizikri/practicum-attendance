<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Helpers\TokenHelper;
use App\Http\Controllers\Controller;
use App\DataTables\AttendanceDataTable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AttendanceDataTable $dataTable)
    {
        return $dataTable->render('admin.attendances.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Schedule $schedule)
    {
        /** @var \App\Models\User $user **/
        $user = auth()->user();

        if (! $user->isRoles([UserRole::Admin, UserRole::Assistant])) {
            return response(['error' => 'User ini bukan asisten/admin'], 403);
        }

        if (! $schedule->whereHas('assistants', function ($query) {
            $query->where('user_id', auth()->id());
        }) && ! $schedule->pj_id == auth()->id() && ! $user->isAdmin()) {
            return response(['error' => 'User ini bukan asisten/admin dari jadwal ini'], 403);
        }

        $token = TokenHelper::generateToken();
        $qrCode = QrCode::size(300)->generate(route('attendances.store', ['token' => $token, 'assistant' => auth()->id(), 'schedule' => $schedule->id]));

        return response($qrCode)->header('Content-Type', 'image/svg+html');
        // return response(['route' => route('attendances.store', ['token' => $token, 'assistant' => auth()->id(), 'schedule' => $schedule->id])]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('admin.attendances.index')->with('success', 'Menghapus presensi berhasil!');
    }
}
