@extends('fe.master')

@section('title', 'Invoice #' . $invoice->id)

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-body p-5">
            <!-- Tombol Print -->
            <div class="text-end mb-4">
                <button onclick="window.print()" class="btn btn-outline-primary">
                    <i class="fas fa-print"></i> Cetak Invoice
                </button>
            </div>

            <!-- Header Invoice -->
            <div class="row mb-5">
                <div class="col-md-6">
                    <h2 class="fw-bold text-primary mb-3">INVOICE</h2>
                    <p class="text-muted mb-1">
                        <strong>INVOICE #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</strong>
                    </p>
                    <p class="text-muted">
                        DATE: {{ \Carbon\Carbon::parse($invoice->tgl_penjualan)->format('M d, Y') }}
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="mb-3">
                        <h3 class="fw-bold text-primary">MediCart</h3>
                        <p class="text-muted mb-0">www.medicart.com</p>
                        <p class="text-muted mb-0">08123456789</p>
                        <p class="text-muted">Jl. Kesehatan No. 123, Jakarta</p>
                    </div>
                </div>
            </div>

            <!-- Info Customer & Pengiriman -->
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="bg-light p-3 rounded">
                        <h5 class="fw-bold mb-3">INFORMASI PELANGGAN</h5>
                        <p class="mb-1"><strong>{{ $invoice->pelanggan->nama_pelanggan }}</strong></p>
                        <p class="mb-1">{{ $invoice->pelanggan->email }}</p>
                        <p class="mb-0">{{ $invoice->pelanggan->no_telp }}</p>
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="bg-light p-3 rounded">
                        <h5 class="fw-bold mb-3">INFORMASI PENGIRIMAN</h5>
                        <p class="mb-1"><strong>Penerima:</strong> {{ $invoice->nama_penerima }}</p>
                        <p class="mb-1"><strong>Alamat:</strong> {{ $invoice->alamat_pengiriman }}</p>
                        <p class="mb-0"><strong>Telepon:</strong> {{ $invoice->no_hp_penerima }}</p>
                    </div>
                </div> --}}
            </div>

            <!-- Tabel Produk -->
            <div class="table-responsive mb-5">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th style="width: 5%">#</th>
                            <th style="width: 50%">PRODUCT</th>
                            <th style="width: 15%">PRICE</th>
                            <th style="width: 10%">QUANTITY</th>
                            <th style="width: 20%">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->detail_penjualan as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->obat->nama_obat }}</td>
                            <td class="text-end">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item->jumlah_beli }}</td>
                            <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="4" class="text-end fw-bold">SUBTOTAL</td>
                            <td class="text-end">Rp {{ number_format($invoice->detail_penjualan->sum('subtotal'), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">Ongkos Kirim</td>
                            <td class="text-end">Rp {{ number_format($invoice->ongkos_kirim, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">Biaya Aplikasi</td>
                            <td class="text-end">Rp {{ number_format($invoice->biaya_app ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="table-active fw-bold">
                            <td colspan="4" class="text-end">TOTAL</td>
                            <td class="text-end">Rp {{ number_format($invoice->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Status dan Metode Pembayaran -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="border p-3 rounded">
                        <h5 class="fw-bold mb-3">METODE PEMBAYARAN</h5>
                        <p class="mb-1">{{ $invoice->metode_bayar->metode_pembayaran }}</p>
                        <p class="mb-0">
                            Status: 
                            <span class="badge {{ $invoice->status_pembayaran == 'Lunas' ? 'bg-success' : 'bg-warning' }}">
                                {{ $invoice->status_pembayaran ?? 'Belum Dibayar' }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border p-3 rounded">
                        <h5 class="fw-bold mb-3">STATUS PESANAN</h5>
                        <p class="mb-0">
                            <span class="badge bg-primary">{{ $invoice->status_order }}</span>
                        </p>
                        @if($invoice->status_resep)
                            <p class="mb-0 mt-2">
                                Status Resep: 
                                <span class="badge bg-info">{{ $invoice->status_resep }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer Terima Kasih -->
            <div class="text-center mt-5 pt-4 border-top">
                <p class="fw-bold text-primary mb-2">THANK YOU FOR YOUR ORDER!</p>
                <p class="text-muted small mb-0">
                    This is a signature of our customer. We are happy to have served you and wish you all the best.<br>
                    We will continue to provide high quality medicine and service. Thank you for choosing us.
                </p>
                <div class="mt-3">
                    <i class="fas fa-heart text-danger"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-smile text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .navbar, .footer, .breadcrumb-section, .btn-outline-primary, .btn-print, .header-icons {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .card-body {
        padding: 0 !important;
    }
    .badge {
        border: 1px solid #000;
        background-color: transparent !important;
        color: #000 !important;
    }
    .table-light {
        background-color: #f5f5f5 !important;
    }
    .bg-light {
        background-color: #f5f5f5 !important;
    }
}
</style>
@endsection