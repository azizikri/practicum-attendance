@extends('admin.layouts.master')


@push('plugin-styles')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Praktikan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Input</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="my-3 card-title">Edit Praktikan</h6>
                    <form class="forms-sample" action="{{ route('admin.students.update', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input name="name" type="text" class="form-control" id="name" autocomplete="off"
                                placeholder="Nama" value="{{ old('name') ?? $user->name }}">
                        </div>

                        <div class="mb-3">
                            <label for="npm" class="form-label">NPM</label>
                            <input name="npm" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                type = "number" maxlength = "8" class="form-control" id="npm" autocomplete="off"
                                placeholder="NPM" value="{{ old('npm') ?? $user->npm }}">
                        </div>

                        <div class="mb-3">
                            <label for="class" class="form-label">Kelas</label>
                            <select class="form-control select-class" id="class" name="class_id">
                                <option selected disabled hidden>Pilih Kelas</option>
                                <option @selected( $user->class_id == null ||  $user->class_id == old('class')) value="">
                                    Non Kelas
                                </option>
                                @forelse ($classes as $class)
                                    <option @selected($class->id == $user->class?->id || $class->id == old('class')) value="{{ $class->id }}">
                                        {{ $class->name }}</option>
                                @empty
                                    <option disabled>No data!</option>
                                @endforelse
                            </select>
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
                        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('.select-class').select2();
        });
    </script>
@endpush
