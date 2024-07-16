@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Kelas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Indeks</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-center">
                        <h6 class="my-3 card-title">Kelas</h6>
                        <a href="{{ route('admin.classes.create') }}">
                            <button type="button" class="mx-3 btn btn-sm btn-primary btn-icon-text">
                                <i class="btn-icon-prepend" data-feather="plus"></i>
                                Input Kelas
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
@push('plugin-scripts')
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
    {{ $dataTable->scripts() }}
@endpush
