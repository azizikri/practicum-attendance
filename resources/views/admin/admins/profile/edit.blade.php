@extends('admin.layouts.master')


@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <div class="row">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- validation error --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title my-3">Edit Profile</h6>
                    <form class="forms-sample" action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input name="name" type="text" class="form-control" id="name" autocomplete="off"
                                placeholder="Nama" value="{{ old('name') ?? auth()->user('admin')->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="email" placeholder="Email"
                                value="{{ old('email') ?? auth()->user('admin')->email }}">
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Save</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title my-3">Ubah Password</h6>
                    <form class="forms-sample" action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password saat ini</label>
                            <input name="current_password" type="password" class="form-control" id="current_password"
                                autocomplete="off" placeholder="Password saat ini">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password baru</label>
                            <input name="password" type="password" class="form-control" id="password"
                                autocomplete="off" placeholder="Password baru">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password baru</label>
                            <input name="password_confirmation" type="password" class="form-control" id="password_confirmation"
                                autocomplete="off" placeholder="Konfirmasi Password baru">
                        </div>


                        <button type="submit" class="btn btn-primary me-2">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
