<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
use App\Models\ClassModel;
use App\Http\Controllers\Controller;
use App\DataTables\AttendanceDataTable;
use App\DataTables\ClassStudentsDataTable;
use App\DataTables\ClassSubjectsDataTable;
use App\DataTables\ScheduleAssistantDataTable;

class AjaxDataTableController extends Controller
{
    public function classStudents(ClassModel $class, ClassStudentsDataTable $dataTableStudents)
    {
        return $dataTableStudents->with('class', $class)->render();
    }

    public function classSubjects(ClassModel $class, ClassSubjectsDataTable $dataTableSubjects)
    {
        return $dataTableSubjects->with('class', $class)->render();
    }

    public function scheduleAttendances(Schedule $schedule, AttendanceDataTable $dataTableAttendances)
    {
        return $dataTableAttendances->with('schedule', $schedule)->render();
    }

    public function scheduleAssistants(Schedule $schedule, ScheduleAssistantDataTable $dataTableSchedule)
    {
        return $dataTableSchedule->with('schedule', $schedule)->render();
    }
}
