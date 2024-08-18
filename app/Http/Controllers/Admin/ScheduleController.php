<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\Schedule;
use App\Enums\ScheduleDay;
use App\Enums\ScheduleShift;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use App\Enums\ScheduleLocation;
use App\Http\Controllers\Controller;
use App\DataTables\ScheduleDataTable;
use App\Http\Requests\Admin\ScheduleRequest;
use App\DataTables\ScheduleAssistantDataTable;
use App\Http\Requests\Admin\UpdateScheduleSession;
use App\Http\Requests\Admin\ScheduleAssistantRequest;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ScheduleDataTable $dataTable)
    {
        return $dataTable->with('role', auth()->user()->role)->render('admin.schedules.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retrieve the current academic year and period from settings
        $academicYear = settings()->get('academic_year');
        $academicPeriod = settings()->get('academic_period');

        // Query to get ClassSubjects without schedules for the current academic year and period
        $classSubjects = ClassSubject::whereDoesntHave('schedules', function ($query) use ($academicYear, $academicPeriod) {
            $query->where('academic_year', $academicYear)
                ->where('academic_period', $academicPeriod);
        })->get(['id', 'class_name', 'subject_name']);

        return view('admin.schedules.create', [
            'classSubjects' => $classSubjects,
            'assistants' => User::whereRole(UserRole::Assistant)->get(['id', 'name']),
            'scheduleLocation' => ScheduleLocation::class,
            'scheduleDay' => ScheduleDay::class,
            'scheduleShift' => ScheduleShift::class,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleRequest $request)
    {
        $data = $request->validated();

        $data['academic_year'] = settings()->get('academic_year');
        $data['academic_period'] = settings()->get('academic_period');

        Schedule::create($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ScheduleAssistantDataTable $dataTable, Schedule $schedule)
    {
        return $dataTable->with('schedule', $schedule)->render('admin.schedules.show', [
            'assistants' => User::whereRole(UserRole::Assistant)->whereDoesntHave('schedules', function ($q) use ($schedule) {
                $q->where('schedule_id', $schedule->id);
            })->where('id', '!=', $schedule->pj_id)->get(),
            'schedule' => $schedule,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        // Retrieve the current academic year and period from settings
        $academicYear = settings()->get('academic_year');
        $academicPeriod = settings()->get('academic_period');

        // Query to get ClassSubjects without schedules for the current academic year and period
        $classSubjects = ClassSubject::whereDoesntHave('schedules', function ($query) use ($academicYear, $academicPeriod, $schedule) {
            $query->where('academic_year', $academicYear)
                ->where('academic_period', $academicPeriod)
                ->where('class_subject_id', '!=', $schedule->class_subject_id);
        })->get(['id', 'class_name', 'subject_name']);

        return view('admin.schedules.edit', [
            'schedule' => $schedule,
            'classSubjects' => $classSubjects,
            'assistants' => User::whereRole(UserRole::Assistant)->get(['id', 'name']),
            'scheduleLocation' => ScheduleLocation::class,
            'scheduleDay' => ScheduleDay::class,
            'scheduleShift' => ScheduleShift::class,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $data = $request->validated();

        $schedule->update($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus!');
    }

    public function addAssistants(ScheduleAssistantRequest $request, Schedule $schedule)
    {
        $data = $request->validated();

        $schedule->assistants()->syncWithoutDetaching($data['assistants']);

        return redirect()->route('admin.schedules.show', $schedule)->with('success', 'Asisten berhasil ditambah!');
    }

    public function deleteAssistant(Schedule $schedule, User $user)
    {
        $schedule->assistants()->detach($user);

        return back()->with('success', 'Asisten berhasil dihapus!');
    }

    public function endSession(Schedule $schedule)
    {
        /** @var \App\Models\User $user **/
        $user = auth()->user();

        if ($schedule->pj_id != $user->id && $user->isAdmin()){
            return back()->with('error', 'Selain PJ dilarang mengedit');
        }

        if ($schedule->session >= $schedule->total_session){
            return back()->with('error', 'Jadwal sudah mencapai ujian');
        }

        $schedule->session += 1;
        $schedule->save();

        return back()->with('success', 'Jadwal berhasil diselesaikan!');
    }

    public function updateSession(UpdateScheduleSession $request, Schedule $schedule)
    {
        $data = $request->validated();

        $schedule->update($data);

        return back()->with('success', 'Session berhasil diupdate!');
    }
}
