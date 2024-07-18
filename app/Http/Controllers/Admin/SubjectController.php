<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubjectDataTable;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubjectDataTable $dataTable)
    {
        return $dataTable->render('admin.subjects.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectRequest $request)
    {
        $data = $request->validated();

        Subject::create($data);

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Praktikum berhasil ditambah!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', [
            'subject' => $subject
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $data = $request->validated();

        $subject->update($data);

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Praktikum berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('admin.subjects.index')->with('success', 'Mata Praktikum berhasil dihapus!');
    }
}
