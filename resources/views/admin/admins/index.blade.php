@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Indeks</li>
        </ol>
    </nav>

    <div class="row">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="card-title my-3">Admin</h6>
                        <a href="{{ route('admin.admins.create') }}">
                            <button type="button" class="btn btn-sm btn-primary btn-icon-text mx-3">
                                <i class="btn-icon-prepend" data-feather="plus"></i>
                                Tambah Admin
                            </button>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ auth()->user('admin')->id == $admin->id ? route('admin.profile.edit') : route('admin.admins.edit', $admin) }}"
                                                    class="text-info mx-3">
                                                    <button type="button"
                                                        class="mr-3 btn btn-sm btn-warning btn-icon-text">
                                                        <i class="btn-icon-prepend" data-feather="edit"></i>
                                                        Edit
                                                    </button>
                                                </a>
                                                <button type="button" class="mr-2 btn btn-sm btn-danger btn-icon-text"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $admin->id }}"
                                                    {{ auth()->user('admin')->id == $admin->id ? 'disabled' : '' }}>
                                                    <i class=" btn-icon-prepend" data-feather="trash"></i>
                                                    Hapus
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    <script src="{{ asset('admin-assets/assets/js/data-table.js') }}"></script>
@endpush
@foreach ($admins as $admin)
    <div class="modal fade" id="deleteModal{{ $admin->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus "{{ $admin->name }}" ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus Admin "{{ $admin->name }}" ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <form id="delete-admin-{{ $admin->id }}" action="{{ route('admin.admins.destroy', $admin) }}"
                        method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="trash"></i>
                            Hapus Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
