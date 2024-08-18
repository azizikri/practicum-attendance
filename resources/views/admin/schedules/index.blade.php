@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Jadwal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Indeks</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-center">
                        <h6 class="my-3 card-title">Jadwal {{ settings()->get('academic_period') }}
                            {{ settings()->get('academic_year') }}</h6>
                        <a href="{{ route('admin.schedules.create') }}">
                            <button type="button" class="mx-3 btn btn-sm btn-primary btn-icon-text">
                                <i class="btn-icon-prepend" data-feather="plus"></i>
                                Input Jadwal
                            </button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<div class="modal fade" id="updateScheduleSessionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-update-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="update-data" action="" method="post">
                @csrf
                @method('patch')
                <div class="modal-body" id="modal-body-update-session">
                    <select class="form-control select-session" name="session" id="session">
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-warning btn-icon-text">
                        Update Data
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
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function() {
            $('#updateScheduleSessionModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var route = button.data('route');
                var modalTitle = button.data('title');
                var totalSession = button.data('total-session');

                $('#modal-update-title').text(modalTitle);
                $('#update-data').attr('action', route);

                var selectSession = $('#session');
                selectSession.empty(); // Clear existing options

                for (var i = 1; i <= totalSession; i++) {
                    selectSession.append(new Option('Pertemuan ' + i, i));
                }

            });
            
            $('.select-session').select2({
                dropdownParent: $('#updateScheduleSessionModal'),
                width: '100%'
            });
        });
    </script>
@endpush
