<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AcademicPeriod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'academicPeriod' => AcademicPeriod::class
        ]);
    }

    public function update(SettingRequest $request)
    {
        $data = $request->validated();

        settings($data);

        return back()->with('success', 'Setting berhasil diubah!');
    }
}
