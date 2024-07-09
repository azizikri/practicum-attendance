@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">User</a></li>
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
                        <h6 class="card-title my-3">User</h6>
                        <a href="{{ route('admin.users.create') }}">
                            <button type="button" class="btn btn-sm btn-primary btn-icon-text mx-3">
                                <i class="btn-icon-prepend" data-feather="plus"></i>
                                Tambah User
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
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="text-info mx-3">
                                                    <button type="button"
                                                        class="mr-3 btn btn-sm btn-warning btn-icon-text">
                                                        <i class="btn-icon-prepend" data-feather="edit"></i>
                                                        Edit
                                                    </button>
                                                </a>
                                                <button type="button" class="mr-2 btn btn-sm btn-danger btn-icon-text"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
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
@foreach ($users as $user)
    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus "{{ $user->name }}" ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus User "{{ $user->name }}" ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <form id="delete-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}"
                        method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="trash"></i>
                            Hapus User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
