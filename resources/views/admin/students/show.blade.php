@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Praktikan</a></li>
            <li class="breadcrumb-item active">{{ $user->name }}</li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>

    {{-- foreach ($schedules as $year => $periods) {
        echo "Academic Year: $year";
        foreach ($periods as $period => $schedules) {
            echo "Academic Period: $period";
            foreach ($schedules as $schedule) {
                echo $schedule->name; // Access individual schedule attributes
            }
        }
    } --}}

    @forelse ($schedules as $year => $periods)
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 d-flex align-items-center">
                            <h6 class="my-3 card-title">Presensi {{ $year }}</h6>
                        </div>

                        @forelse ($periods as $period => $schedules)
                            <h6 class="my-3 card-title">Periode {{ ucfirst($period) }}</h6>
                            @foreach ($schedules as $index => $schedule)
                                <h6 class="my-3 card-title">Jadwal {{ $schedule->class_subject_name }}</h6>

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Pertemuan</th>
                                                <th>Presensi</th>
                                                <th>
                                                    Tanggal
                                                </th>
                                                <th>
                                                    Asisten yang mengabsen
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($schedule->checkAttendances($user) as $session => $atttendance)
                                                <tr>
                                                    <th>{{ $session }}</th>
                                                    <td>{{ $attendance['status'] }}</td>
                                                    <td> {{ $attendance['created_at'] == 'Tidak ada Data' ? $attendance['created_at'] : \Carbon\Carbon::parse($attendance['created_at'])->translatedFormat('d F Y') }}
                                                    </td>
                                                    <td>{{ $attendance['assistant_name'] }}</td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3">Tidak ada data presensi</td>
                                                </tr>
                                            @endforelse
                                            <!-- Example Data, replace with actual schedule-related data -->
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                            @empty
                                <p class="text-muted">No schedules available for this period.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="text-center card-body">
                                <p class="text-muted">No schedules available for this academic year.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse

        @endsection
