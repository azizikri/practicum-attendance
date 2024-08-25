@extends('admin.layouts.master2')

@section('content')
    <div class="page-content d-flex align-items-center justify-content-center">

        <div class="mx-0 row w-100 auth-page">
            <div class="mx-auto col-md-8 col-xl-6">
                <div class="card">
                    <div class="row">
                        <div class="col-md-8 ps-md-0">
                            <div class="px-4 py-5 auth-form-wrapper">
                                <a href="#" class="mb-2 noble-ui-logo d-block">Practicum Attendance</a>
                                <h5 class="mb-4 text-muted fw-normal">Selamat datang kembali! silahkan login.</h5>
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <form class="forms-sample" action="{{ route('admin.login') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="userEmail" class="form-label">Email</label>
                                        <input name="email" type="email" class="form-control" id="userEmail"
                                            placeholder="Email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="userPassword" class="form-label">Password</label>
                                        <input name="password" type="password" class="form-control" id="userPassword"
                                            autocomplete="current-password" placeholder="Password">
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="authCheck">
                                        <label class="form-check-label" for="authCheck">
                                            Ingat saya
                                        </label>
                                    </div>
                                    <div>
                                        <button type="submit" class="mb-2 btn btn-primary me-2 mb-md-0">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
