@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Kelas</a></li>
            <li class="breadcrumb-item active">{{ $class->name }}</li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-center">
                        <h6 class="my-3 card-title">Praktikan Kelas {{ $class->name }}</h6>
                        <button type="button" class="mx-3 btn btn-sm btn-success btn-icon-text" data-bs-toggle="modal"
                            data-bs-target="#inputPraktikan">
                            <i class=" btn-icon-prepend" data-feather="users"></i>
                            Input Praktikan
                        </button>
                    </div>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            {{ $dataTableClassStudents->table(['id'=>'dataTableClassStudents']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-center">
                        <h6 class="my-3 card-title">Mata Praktikum Kelas {{ $class->name }}</h6>
                        <button type="button" class="mx-3 btn btn-sm btn-success btn-icon-text" data-bs-toggle="modal"
                            data-bs-target="#inputMataPraktikum">
                            <i class=" btn-icon-prepend" data-feather="users"></i>
                            Input Mata Praktikum
                        </button>
                    </div>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            {{ $dataTableClassSubjects->table(['id'=>'dataTableClassSubjects']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="inputPraktikan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Praktikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('admin.classes.students.store', $class) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="student" class="form-label">Praktikan</label>
                        <select class="form-control select-student" id="student" name="students[]"
                            multiple="multiple">
                            @forelse ($students as $student)
                                <option value="{{ $student->id }}" @selected(in_array($student->id, old('students', [])))>
                                    {{ $student->name }}
                                </option>
                            @empty
                                <option disabled>No data!</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary btn-icon-text">
                        <i class="btn-icon-prepend" data-feather="plus"></i>
                        Input Praktikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="inputMataPraktikum" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Mata Praktikum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('admin.classes.subjects.store', $class) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subject" class="form-label">Praktikan</label>
                        <select class="form-control select-subject" id="subject" name="subjects[]"
                            multiple="multiple">
                            @forelse ($subjects as $subject)
                                <option value="{{ $subject->id }}" @selected(in_array($subject->id, old('subjects', [])))>
                                    {{ $subject->name }}
                                </option>
                            @empty
                                <option disabled>No data!</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary btn-icon-text">
                        <i class="btn-icon-prepend" data-feather="plus"></i>
                        Input Mata Praktikum
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('plugin-scripts')
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    {{ $dataTableClassStudents->scripts() }}
    {{ $dataTableClassSubjects->scripts() }}

    <script>
        $(document).ready(function() {
            $('.select-student').select2({
                dropdownParent: $('#inputPraktikan'),
                width: '100%'
            });

            $('.select-subject').select2({
                dropdownParent: $('#inputMataPraktikum'),
                width: '100%'
            });
        });
    </script>
@endpush
