@extends('admin.layouts.master')

@push('plugin-styles')
<link href="{{ asset('admin-assets/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">Jadwal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Input</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="my-3 card-title">Input Jadwal</h6>
                    <form class="forms-sample" action="{{ route('admin.schedules.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="academic_year" class="form-label">Tahun Akademik</label>
                            <input type="text" class="form-control" id="academic_year"
                                autocomplete="off" placeholder="Tahun Akademik"
                                value="{{ settings()->get('academic_year') }}" pattern="\d{4}/\d{4}"
                                title="Format yang benar adalah YYYY/YYYY" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label for="academic_period" class="form-label">Periode Akademik</label>
                            <select class="form-control select-academic-period" id="academic_period" name="academic_period" disabled>
                                <option selected disabled>
                                    {{ strtoupper(settings()->get('academic_period')) }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="class_subject_id" class="form-label">Kelas/Mata Praktikum</label>
                            <select class="form-control select-class-subject" id="class_subject_id" name="class_subject_id">
                                @foreach ($classSubjects as $classSubject)
                                    <option value="{{ $classSubject->id }}" @selected($classSubject->id == old('class_subject_id'))>
                                        {{ $classSubject->class_name }} - {{ $classSubject->subject_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pj_id" class="form-label">PJ</label>
                            <select class="form-control select-pj" id="pj_id" name="pj_id">
                                @foreach ($assistants as $assistant)
                                    <option value="{{ $assistant->id }}" @selected($assistant->id == old('pj_id'))>
                                        {{ $assistant->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi</label>
                            <select class="form-control select-schedule-location" id="location" name="location">
                                @foreach ($scheduleLocation::getKeys() as $location)
                                    <option value="{{ $scheduleLocation::getValue($location) }}" @selected($scheduleLocation::getValue($location) == old('location'))>
                                        {{ $location }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="day" class="form-label">Hari</label>
                            <select class="form-control select-schedule-day" id="day" name="day">
                                @foreach ($scheduleDay::getKeys() as $day)
                                    <option value="{{ $scheduleDay::getValue($day) }}" @selected($scheduleDay::getValue($day) == old('day'))>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="shift" class="form-label">Shift</label>
                            <select class="form-control select-schedule-shift" id="shift" name="shift">
                                @foreach ($scheduleShift::getKeys() as $shift)
                                    <option value="{{ $scheduleShift::getValue($shift) }}" @selected($scheduleShift::getValue($shift) == old('shift'))>
                                        {{ $shift }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="total_session" class="form-label">Jumlah Pertemuan</label>
                            <input name="total_session" type="text" class="form-control" id="total_session" autocomplete="off"
                                placeholder="Jumlah Pertemuan" value="{{ old('total_session') }}">
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('admin-assets/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('.select-class-subject').select2();
            $('.select-pj').select2();
            $('.select-schedule-location').select2();
            $('.select-schedule-day').select2();
        $('.select-schedule-shift').select2();
        });
    </script>
@endpush
