@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-assets/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Praktikan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Indeks</li>
        </ol>
    </nav>

    <div class="row">
        @if (session()->has('failures'))
            <table class="table table-danger">
                <tr>
                    <th>Baris</th>
                    <th>Kolom</th>
                    <th>Error</th>
                    <th>Value</th>
                </tr>

                @foreach (session()->get('failures') as $validation)
                    <tr>
                        <td>{{ $validation->row() }}</td>
                        <td>{{ $validation->attribute() }}</td>
                        <td>
                            <ul>
                                @foreach ($validation->errors() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            {{ $validation->values()[$validation->attribute()] }}
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-center">
                        <h6 class="my-3 card-title">Praktikan</h6>
                        <a href="{{ route('admin.students.create') }}">
                            <button type="button" class="mx-3 btn btn-sm btn-primary btn-icon-text">
                                <i class="btn-icon-prepend" data-feather="plus"></i>
                                Input Praktikan
                            </button>
                        </a>
                        <button type="button" class="mx-3 btn btn-sm btn-success btn-icon-text" data-bs-toggle="modal"
                            data-bs-target="#importStudentModal">
                            <i class=" btn-icon-prepend" data-feather="file"></i>
                            Import Praktikan
                        </button>
                        <a href="{{ asset('assets/csv/template_import_praktikan.xlsx') }}"
                            class="mx-3 btn btn-sm btn-success btn-icon-text" download>
                            <i class=" btn-icon-prepend" data-feather="download"></i>
                            Download Template
                        </a>
                        <a href="{{ route('admin.students.end-year') }}"
                            class="mx-3 btn btn-sm btn-dark btn-icon-text">
                            <i class=" btn-icon-prepend" data-feather="trending-up"></i>
                            End Year
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

<div class="modal fade" id="importStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Praktikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('admin.students.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_sheet" class="form-label">File CSV/Excel</label>
                        <input type="file" id="importCsv" name="file_sheet" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary btn-icon-text">
                        <i class="btn-icon-prepend" data-feather="plus"></i>
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('plugin-scripts')
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
    {{ $dataTable->scripts() }}
    <script>
        $('#importCsv').dropify();
    </script>
@endpush
