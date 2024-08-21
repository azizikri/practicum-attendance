<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $academicYear = settings()->get('academic_year');
        $academicPeriod = settings()->get('academic_period');

        $schedules = auth()->user()->schedules()
            ->where('academic_year', $academicYear)
            ->where('academic_period', $academicPeriod)
            ->with('attendances')
            ->get()
            ->groupBy(['academic_year', 'academic_period']);

        return view('dashboard', [
            'schedules' => $schedules
        ]);
    }
}
