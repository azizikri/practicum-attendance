@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Schedule</a></li>
            <li class="breadcrumb-item active">{{ $schedule->class_subject_name }}</li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-center">
                        <h6 class="my-3 card-title">Presensi {{ $schedule->class_subject_name }}</h6>
                    </div>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            {{ $dataTableScheduleAttendances->table(['id' => 'dataTableScheduleAttendances']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('isAdmin', auth()->user())
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 d-flex align-items-center">
                            <h6 class="my-3 card-title">Asisten - {{ $schedule->class_subject_name }}</h6>
                            <button type="button" class="mx-3 btn btn-sm btn-success btn-icon-text" data-bs-toggle="modal"
                                data-bs-target="#inputAssisten">
                                <i class=" btn-icon-prepend" data-feather="users"></i>
                                Input Asisten
                            </button>
                        </div>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                {{ $dataTableScheduleAssistants->table(['id' => 'dataTableScheduleAssistants']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
@endsection

@can('isAdmin', auth()->user())
    <div class="modal fade" id="inputAssisten" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Input Assisten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="{{ route('admin.schedules.assistants.store', $schedule) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="assistant" class="form-label">Assisten</label>
                            <select class="form-control select-assistant" id="assistant" name="assistants[]"
                                multiple="multiple">
                                @forelse ($assistants as $assistant)
                                    <option value="{{ $assistant->id }}" @selected(in_array($assistant->id, old('assistants', [])))>
                                        {{ $assistant->name }}
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
                            Input Assisten
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcan


@push('plugin-scripts')
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="{{ asset('admin-assets/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('custom-scripts')
    {{ $dataTableScheduleAttendances->scripts() }}

    @can('isAdmin', auth()->user())
        {{ $dataTableScheduleAssistants->scripts() }}
        <script>
            $(document).ready(function() {
                $('.select-assistant').select2({
                    dropdownParent: $('#inputAssisten'),
                    width: '100%'
                });
            });
        </script>
    @endcan

@endpush
