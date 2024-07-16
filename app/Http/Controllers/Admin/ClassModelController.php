<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClassModel;
use App\Http\Requests\ClassRequest;
use App\DataTables\ClassesDataTable;
use App\Http\Controllers\Controller;


class ClassModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ClassesDataTable $dataTable)
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
}
