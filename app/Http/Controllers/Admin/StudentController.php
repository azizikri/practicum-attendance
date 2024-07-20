<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\ClassModel;
use App\DataTables\UserDataTable;
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
        return view('admin.students.create');
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
}
