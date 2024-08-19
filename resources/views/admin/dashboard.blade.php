@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="flex-wrap d-flex justify-content-between align-items-center grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Selamat datang, {{ auth()->user()->name }}</h4>
        </div>
    </div>
    @can('isAdmin', auth()->user())
        <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow-1">
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="mb-0 card-title">Praktikan</h6>

                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5">
                                        <h3 class="mb-2">{{ $studentCount }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="mb-0 card-title">Asisten</h6>

                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5">
                                        <h3 class="mb-2">{{ $assistantCount }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="mb-0 card-title">Jadwal {{ settings()->get('academic_year') }} -
                                        {{ settings()->get('academic_period') }} </h6>

                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5">
                                        <h3 class="mb-2">{{ $scheduleCount }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->
    @endcan
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-center">
                        <h6 class="my-3 card-title">Pesanan (Pending)</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Pesanan</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Status Pemesanan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Total Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingOrders as $order)
                                    <tr>
                                        <td>{{ str()->of($order->uuid)->limit(10) }}</td>
                                        <td>
                                            @if ($order->evidence_of_payment != null)
                                                <a href="{{ Storage::url($order->evidence_of_payment) }}" target="_blank">
                                                    <button type="button" class="btn btn-sm btn-primary btn-icon-text">
                                                        <i class="btn-icon-prepend" data-feather="download"></i>
                                                        Download
                                                    </button>
                                                </a>
                                            @else
                                                <button type="button" class="btn btn-sm btn-danger btn-icon-text">
                                                    <i class="btn-icon-prepend" data-feather="x"></i>
                                                    Tidak ada
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <form id="change-order-status-{{ $order->uuid }}"
                                                action="{{ route('admin.orders.change-order-status', $order) }}"
                                                method="post">
                                                @csrf
                                                @method('patch')
                                                <select class="mb-3 form-select form-select-sm" name="order_status"
                                                    onchange="
                                                    if(confirm('Apakah anda yakin ingin mengubah status pemesanan ini?')) {
                                                        event.preventDefault();
                                                        document.getElementById('change-order-status-{{ $order->uuid }}').submit();
                                                    } else {
                                                        event.preventDefault();
                                                    }
                                                ">
                                                    @foreach ($orderEnums::cases() as $enum)
                                                        @if ($order->services()->count() < 1 && $enum == $orderEnums::COURIER)
                                                            @continue
                                                        @endif
                                                        <option value="{{ $enum }}"
                                                            {{ $order->order_status == $enum ? 'selected' : '' }}>
                                                            {{ $enum }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>

                                        <td>
                                            <form id="change-payment-status-{{ $order->uuid }}"
                                                action="{{ route('admin.orders.change-payment-status', $order) }}"
                                                method="post">
                                                @csrf
                                                @method('patch')
                                                <select class="mb-3 form-select form-select-sm" name="payment_status"
                                                    onchange="
                                                    if(confirm('Apakah anda yakin ingin mengubah status pembayaran ini?')) {
                                                        event.preventDefault();
                                                        document.getElementById('change-payment-status-{{ $order->uuid }}').submit();
                                                    } else {
                                                        event.preventDefault();
                                                    }
                                                ">
                                                    @foreach ($paymentEnums::cases() as $enum)
                                                        <option value="{{ $enum }}"
                                                            {{ $order->payment_status == $enum ? 'selected' : '' }}>
                                                            {{ $enum }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>

                                        <td>{{ 'Rp. ' . number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('admin.orders.show', $order) }}">
                                                    <button type="button"
                                                        class="mx-3 btn btn-sm btn-primary btn-icon-text">
                                                        <i class="btn-icon-prepend" data-feather="eye"></i>
                                                        Lihat Detail
                                                    </button>
                                                </a>
                                                <button type="button" class="mr-2 btn btn-sm btn-danger btn-icon-text"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $order->id }}">
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
    </div> <!-- row --> --}}
@endsection

<div class="modal fade" id="showQRModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-qr-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="gap-3 modal-body d-flex flex-column align-items-center justify-content-center">
                <h3 id="timer">Valid for: <span id="countdown"></span> seconds</h3>
                <div id="qr-code-container"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>

@push('plugin-scripts')
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush

@push('custom-scripts')
    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var interval;

            function startCountdown(route, container) {
                var now = new Date();
                var seconds = now.getSeconds();
                var countdown = 60 - seconds;

                $('#countdown').text(countdown);

                interval = setInterval(function() {
                    countdown--;
                    $('#countdown').text(countdown);

                    if (countdown <= 0) {
                        updateQRCode(route, container);
                        countdown = 60;
                    }
                }, 1000);
            }

            function updateQRCode(route, container) {
                $.ajax({
                    url: route,
                    type: 'GET',
                    dataType: 'html',
                    success: function(data) {
                        if (data) {
                            // Ensure the data is properly formatted as an SVG image
                            $(container).empty();
                            $(container).append(data);
                        } else {
                            console.error("No data received for QR code.");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error: ", textStatus,
                            errorThrown); // Debug: Log any AJAX errors
                    }
                });
            }

            $('#showQRModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modalTitle = button.data('title');
                $('#modal-qr-title').text(modalTitle);

                updateQRCode(button.data('route'), '#qr-code-container');
                startCountdown(button.data('route'), '#qr-code-container');
            });

            $('#showQRModal').on('hidden.bs.modal', function() {
                clearInterval(interval);
            });
        });
    </script>
@endpush
