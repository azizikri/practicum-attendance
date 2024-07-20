<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\Subject;
use App\Models\ClassModel;
use App\Http\Requests\Admin\ClassRequest;
use App\DataTables\ClassDataTable;
use App\Http\Controllers\Controller;
use App\DataTables\ClassStudentsDataTable;
use App\DataTables\ClassSubjectsDataTable;
use App\Http\Requests\Admin\ClassStudentRequest;
use App\Http\Requests\Admin\ClassSubjectRequest;

class ClassModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ClassDataTable $dataTable)
    {
        return $dataTable->render('admin.classes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassRequest $request)
    {
        $data = $request->validated();

        ClassModel::create($data);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil ditambah!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(ClassStudentsDataTable $dataTableStudents, ClassSubjectsDataTable $dataTableSubjects, ClassModel $class)
    {
        return view("admin.classes.show", [
            'class' => $class,
            'students' => User::whereRole(UserRole::Student)->whereNull('class_id')->get(),
            'subjects' => Subject::whereDoesntHave('classes', function ($q) use ($class) {
                $q->where('classes.id', $class->id);
            })->get(['id', 'name', 'short_name']),
            'dataTableClassStudents' => $dataTableStudents->with('class', $class)->html()->ajax([
                "url" => route('admin.data-table.class.students', $class),
                "type" => "GET",
            ]),
            'dataTableClassSubjects' => $dataTableSubjects->with('class', $class)->html()->ajax([
                "url" => route('admin.data-table.class.subjects', $class),
                "type" => "GET",
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassModel $class)
    {
        return view('admin.classes.edit', [
            'class' => $class
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassRequest $request, ClassModel $class)
    {
        $data = $request->validated();

        $class->update($data);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassModel $class)
    {
        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus!');
    }

    public function addStudents(ClassStudentRequest $request, ClassModel $class)
    {
        $data = $request->validated();

        User::whereIn('id', $data)->update(['class_id' => $class->id]);

        return redirect()->route('admin.classes.show', $class)->with('success', 'Pratikan berhasil ditambah!');
    }

    public function deleteStudent(User $user)
    {
        $user->update(['class_id' => null]);

        return back()->with('success', 'Pratikan berhasil dihapus!');
    }

    public function addSubjects(ClassSubjectRequest $request, ClassModel $class)
    {
        $data = $request->validated();

        $class->subjects()->syncWithoutDetaching($data['subjects']);

        return redirect()->route('admin.classes.show', $class)->with('success', 'Mata Praktikum berhasil ditambah!');
    }

    public function deleteSubject(ClassModel $class, Subject $subject)
    {
        $class->subjects()->detach($subject);

        return back()->with('success', 'Mata Praktikum berhasil dihapus!');
    }
}
