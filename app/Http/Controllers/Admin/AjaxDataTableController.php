<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClassModel;
use App\Http\Controllers\Controller;
use App\DataTables\ClassStudentsDataTable;
use App\DataTables\ClassSubjectsDataTable;

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
}
