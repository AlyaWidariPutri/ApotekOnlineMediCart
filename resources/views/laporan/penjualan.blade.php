@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Laporan Penjualan</h4>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <!-- Filter Card -->
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('laporan.penjualan') }}" class="row">
                            <div class="col-md-3">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Status Pesanan</label>
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu Konfirmasi" {{ request('status') == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Menunggu Kurir" {{ request('status') == 'Menunggu Kurir' ? 'selected' : '' }}>Menunggu Kurir</option>
                                    <option value="Sedang Dikirim" {{ request('status') == 'Sedang Dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('laporan.penjualan') }}" class="btn btn-secondary mr-2">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                                <a href="{{ route('laporan.penjualan.pdf', request()->all()) }}" class="btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Statistik Card -->
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Penjualan</h5>
                                <h2 class="mb-0">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h2>
                                <small>Semua transaksi</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Pendapatan (Selesai)</h5>
                                <h2 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                                <small>Transaksi selesai</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Transaksi</h5>
                                <h2 class="mb-0">{{ $totalTransaksi }}</h2>
                                <small>Semua transaksi</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Transaksi Selesai</h5>
                                <h2 class="mb-0">{{ $totalTransaksiSelesai ?? 0 }}</h2>
                                <small>Pesanan selesai</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Laporan -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Detail Penjualan</h4>
                    </div>
                    <div class="card-body">
                        @if($penjualan->isEmpty())
                            <div class="alert alert-info">Tidak ada data penjualan.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>No. Invoice</th>
                                            <th>Pelanggan</th>
                                            <th>Total Bayar</th>
                                            <th>Status</th>
                                            <th>Metode Bayar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($penjualan as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tgl_penjualan)->format('d/m/Y H:i') }}</td>
                                            <td>#{{ $item->id }}</td>
                                            <td>{{ $item->pelanggan->nama_pelanggan ?? '-' }}</td>
                                            <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'Menunggu Konfirmasi' => 'warning',
                                                        'Diproses' => 'info',
                                                        'Menunggu Kurir' => 'primary',
                                                        'Sedang Dikirim' => 'info',
                                                        'Selesai' => 'success',
                                                    ];
                                                    $color = $statusColors[$item->status_order] ?? 'secondary';
                                                @endphp
                                                <span class="badge badge-{{ $color }}">{{ $item->status_order }}</span>
                                            </td>
                                            <td>{{ $item->metode_bayar->metode_pembayaran ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('penjualan.show', $item->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-dark">
                                            <td colspan="4" class="text-end fw-bold">GRAND TOTAL</td>
                                            <td class="fw-bold">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection