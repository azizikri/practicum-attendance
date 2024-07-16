<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRole;
use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\UserRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->with('role', UserRole::Admin)->render('admin.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['role'] = UserRole::Admin;

        User::create($data);

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil ditambah!');

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.admins.edit', [
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

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (! $this->checkAdmin()) {
            return back()->with('error', 'Admin hanya satu! Tidak boleh dihapus!');
        }

        $user->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil dihapus');
    }

    private function checkAdmin() : bool
    {
        return User::whereRole(UserRole::Admin)->count() > 1;
    }
}
