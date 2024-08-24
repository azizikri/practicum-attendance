<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\UserRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->with('role', UserRole::Student)->render('admin.students.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.students.create', [
            'classes' => ClassModel::get(['id', 'name']),
        ]);
    }

    public function show(User $user)
    {
        if (! $user->isStudent()) {
            return redirect()->route('admin.students.index');
        }

        $academicYear = settings()->get('academic_year');
        $academicPeriod = settings()->get('academic_period');

        $schedules = $user->schedules()
            ->where('academic_year', $academicYear)
            ->where('academic_period', $academicPeriod)
            ->with('attendances')
            ->get()
            ->groupBy(['academic_year', 'academic_period']);

        return view('admin.students.show', [
            'user' => $user,
            'schedules' => $schedules
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['role'] = UserRole::Student;

        User::create($data);

        return redirect()->route('admin.students.index')->with('success', 'Praktikan berhasil ditambah!');

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.students.edit', [
            'classes' => ClassModel::get(['id', 'name']),
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $data['password'] = $request->password != null ? Hash::make($request->password) : $user->password;

        $user->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Praktikan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.students.index')->with('success', 'Praktikan berhasil dihapus');
    }

    public function import(Request $request)
    {
        set_time_limit(500);
        $request->validate([
            'file_sheet' => ['required', 'file', 'mimes:csv,xlsx'],
        ]);

        $import = new StudentImport();
        $import->import($request->file('file_sheet'));

        if ($import->failures) {
            return back()->with('success', 'Data berhasil diimport')->withFailures($import->failures);
        }

        return back()->with('success', 'Data berhasil diimport');
    }

    public function endYear()
    {
        set_time_limit(500);
        // Define the final year class prefix
        $finalYearPrefix = '4IA';

        // Start a transaction
        DB::transaction(function () use ($finalYearPrefix) {
            // Chunk through users and update their classes
            User::whereRole(UserRole::Student)->whereHas('class')
                ->chunk(1000, function ($users) use ($finalYearPrefix) {
                    $updates = [];
                    $finalYearUsers = [];

                    foreach ($users as $user) {
                        $class = $user->class;
                        $currentYear = (int) $class->name[0]; // Assuming class name starts with the year number
                        $newYear = $currentYear + 1;
                        $newClassName = $newYear . substr($class->name, 1);

                        if (strpos($class->name, $finalYearPrefix) === 0) {
                            $finalYearUsers[] = $user->id;
                        } else {
                            // Find or create the new class
                            $newClass = ClassModel::where('name', $newClassName)->first();

                            // Add update to batch
                            $updates[$user->id] = ['class_id' => $newClass->id];
                        }
                    }

                    // Perform bulk update
                    foreach ($updates as $id => $data) {
                        User::where('id', $id)->update($data);
                    }

                    // Set class_id to null for final year users
                    if (! empty($finalYearUsers)) {
                        User::whereIn('id', $finalYearUsers)->update(['class_id' => null]);
                    }
                });
        });

        return redirect()->route('admin.students.index')->with('success', 'Praktikan berhasil di update!');
    }
}
