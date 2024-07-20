<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRole;
use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\UserRequest;

class AssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->with('role', UserRole::Assistant)->render('admin.assistants.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.assistants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['role'] = UserRole::Assistant;

        User::create($data);

        return redirect()->route('admin.assistants.index')->with('success', 'Asisten berhasil ditambah!');

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.assistants.edit', [
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

        return redirect()->route('admin.assistants.index')->with('success', 'Asisten berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.assistants.index')->with('success', 'Asisten berhasil dihapus');
    }
}
