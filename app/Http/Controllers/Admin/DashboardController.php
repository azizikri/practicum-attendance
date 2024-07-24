<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\ClassSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ScheduleDashboardDataTable;

class DashboardController extends Controller
{
    public function __invoke(ScheduleDashboardDataTable $dataTable)
    {
        $assistantCount = User::whereRole(UserRole::Assistant)->count();
        $studentCount = User::whereRole(UserRole::Student)->count();
        $classSubjectCount = ClassSubject::count();

        return $dataTable->render('admin.dashboard', [
            'assistantCount' => $assistantCount,
            'studentCount' => $studentCount,
            'classSubjectCount' => $classSubjectCount,
        ]);
    }
}
