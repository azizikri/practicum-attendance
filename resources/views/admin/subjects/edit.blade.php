@extends('admin.layouts.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}">Mata Praktikum</a></li>
            <li class="breadcrumb-item active" aria-current="page">Input</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="my-3 card-title">Edit Mata Praktikum</h6>
                    <form class="forms-sample" action="{{ route('admin.subjects.update', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input name="name" type="text" class="form-control" id="name" autocomplete="off"
                                placeholder="Nama" value="{{ old('name') ?? $user->name }}">
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
