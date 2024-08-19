<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\Schedule;
use App\Http\Controllers\Controller;
use App\DataTables\ScheduleDashboardDataTable;

class DashboardController extends Controller
{
    public function __invoke(ScheduleDashboardDataTable $dataTable)
    {
        $assistantCount = User::whereRole(UserRole::Assistant)->count();
        $studentCount = User::whereRole(UserRole::Student)->count();
        $scheduleCount = Schedule::where('academic_year', settings()->get('academic_year'))
            ->where('academic_period', settings()->get('academic_period'))
            ->count();

        return $dataTable->render('admin.dashboard', [
            'assistantCount' => $assistantCount,
            'studentCount' => $studentCount,
            'scheduleCount' => $scheduleCount,
        ]);
    }
}
