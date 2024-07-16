@extends('admin.layouts.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.assistants.index') }}">Asisten</a></li>
            <li class="breadcrumb-item active" aria-current="page">Input</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="my-3 card-title">Input Asisten</h6>
                    <form class="forms-sample" action="{{ route('admin.assistants.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input name="name" type="text" class="form-control" id="name" autocomplete="off"
                                placeholder="Nama" value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="email" autocomplete="off"
                                placeholder="Email" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" id="password" autocomplete="off"
                                placeholder="Password">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input name="password_confirmation" type="password" class="form-control"
                                id="password_confirmation" autocomplete="off" placeholder="Password">
                        </div>


                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <a href="{{ route('admin.assistants.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
