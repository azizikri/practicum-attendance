<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

class AttendancesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStrictNullComparison, WithEvents
{
    protected $schedule;

    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    public function collection()
    {
        // Debugging: Check if schedule is received
        \Log::info('Schedule ID: ' . $this->schedule);

        $schedule = $this->schedule;

        // Debugging: Check if schedule is found
        if (!$schedule) {
            \Log::error('Schedule not found for ID: ' . $this->schedule);
            return collect([]);
        }

        $query = Attendance::query();

        $query->where('schedule_id', $this->schedule->id);

        $attendances = $query->get();

        // Debugging: Check if attendances are found
        \Log::info('Attendances found: ' . $attendances->count());

        $students = $attendances->pluck('student_name')->unique();
        $totalSessions = $schedule->total_session;

        // Debugging: Check total sessions
        \Log::info('Total Sessions: ' . $totalSessions);

        $data = $students->map(function ($student) use ($attendances, $totalSessions) {
            $row = [$student];
            for ($i = 1; $i <= $totalSessions; $i++) {
                $row[] = $attendances->where('student_name', $student)->where('session', $i)->count() ? 100 : 0;
            }
            return $row;
        });

        return $data;
    }

    public function headings() : array
    {
        $schedule = $this->schedule;
        $totalSessions = $schedule->total_session;
        $headings = ['Nama'];
        for ($i = 1; $i <= $totalSessions; $i++) {
            $headings[] = 'Pertemuan ' . $i;
        }
        return $headings;
    }

    public function map($row) : array
    {
        return $row;
    }

    public function title() : string
    {
        return 'Presensi';
    }

    public function registerEvents() : array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:' . $event->sheet->getHighestColumn() . '1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
