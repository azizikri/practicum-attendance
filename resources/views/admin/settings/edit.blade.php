@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">App Settings</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="my-3 card-title">Edit Setting</h6>
                    <form class="forms-sample" action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="academic_year" class="form-label">Tahun Akademik (eg: 2023/2024)</label>
                            <input name="academic_year" type="text" class="form-control" id="academic_year"
                                autocomplete="off" placeholder="Tahun Akademik"
                                value="{{ old('academic_year') ?? settings()->get('academic_year') }}" pattern="\d{4}/\d{4}"
                                title="Format yang benar adalah YYYY/YYYY">
                        </div>

                        <div class="mb-3">
                            <label for="academic_period" class="form-label">Periode Akademik</label>
                            <select class="form-control select-academic-period" id="academic_period" name="academic_period">
                                @foreach ($academicPeriod::getKeys() as $period)
                                    <option value="{{ $academicPeriod::getValue($period) }}" @selected($academicPeriod::getValue($period) == old('academic_period', settings()->get('academic_period')))>
                                        {{ $period }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('admin-assets/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('.select-academic-period').select2();
        });
    </script>
@endpush
