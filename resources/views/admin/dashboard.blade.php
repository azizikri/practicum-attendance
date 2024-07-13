@extends('admin.layouts.master')

@push('plugin-styles')
    <link href="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="flex-wrap d-flex justify-content-between align-items-center grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Selamat datang di Dasbor</h4>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="mb-0 card-title">Pelanggan</h6>

                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $userCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="mb-0 card-title">Produk</h6>

                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $productCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="mb-0 card-title">Servis</h6>

                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $serviceCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="mb-0 card-title">Total Pemesanan</h6>

                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $totalOrderCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="mb-0 card-title">Total Pemesanan Selesai</h6>

                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $orderCompletedCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> -- }} <!-- row -->

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

@push('plugin-scripts')
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('admin-assets/assets/js/data-table.js') }}"></script>
@endpush
