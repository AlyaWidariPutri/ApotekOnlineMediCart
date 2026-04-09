@extends('fe.master')

@section('title', 'Checkout Summary')

@section('content')
<style>
    /* Styling khusus mengikuti referensi gambar */
    .invoice-container {
        background-color: #f8f9fa; /* Warna dasar kertas */
        border: 1px solid #ddd;
        position: relative;
        overflow: hidden;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    /* Dekorasi Kotak-kotak (Checkerboard) di samping kanan */
    .invoice-container::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 40px;
        height: 100%;
        background-image: 
            linear-gradient(45deg, var(--bs-primary) 25%, transparent 25%), 
            linear-gradient(-45deg, var(--bs-primary) 25%, transparent 25%), 
            linear-gradient(45deg, transparent 75%, var(--bs-primary) 75%), 
            linear-gradient(-45deg, transparent 75%, var(--bs-primary) 75%);
        background-size: 20px 20px;
        background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        opacity: 0.8;
    }

    .inv-header-text {
        font-size: 4rem;
        font-weight: 800;
        line-height: 0.8;
        color: var(--bs-primary);
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .table-custom {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table-custom thead th {
        background-color: #f5801f !important; 
        color: white;
        border: none;
        padding: 15px;
    }

    .table-custom tbody tr {
        background-color: #e9ecef;
    }

    .table-custom td {
        padding: 15px;
        border: none;
    }

    .total-banner {
        background-color: var(--bs-primary);
        color: white;
        padding: 15px;
        font-weight: bold;
        font-size: 1.2rem;
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .final-amount-box {
        border: 4px solid #333;
        padding: 20px;
        text-align: center;
        margin-top: 20px;
    }

    .final-amount-box h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
    }

    @media (max-width: 768px) {
        .invoice-container::after { display: none; }
    }
</style>

<div class="container py-5">
    <div class="card invoice-container shadow-sm p-4 p-md-5">
        <div class="row align-items-start mb-5">
            <div class="col-md-6">
                <div class="inv-header-text">ORDER<br>SUMMARY</div>
            </div>
            <div class="col-md-3 small">
                <p class="mb-0"><strong>Invoice To</strong></p>
                <p class="text-muted">
                    {{ $invoice->pelanggan->nama_pelanggan ?? '-' }}<br>
                    {{ $invoice->pelanggan->email ?? '-' }}<br>
                    {{ $invoice->pelanggan->no_telp ?? '-' }}
                </p>
            </div>
            {{-- <div class="col-md-3 small">
                <p class="mb-0"><strong>Shipping To</strong></p>
                <p class="text-muted">
                    {{ $invoice->nama_penerima ?? '-' }}<br>
                    {{ $invoice->alamat_pengiriman ?? '-' }}<br>
                    {{ $invoice->no_hp_penerima ?? '-' }}
                </p>
            </div> --}}
        </div>

        <hr>

        <div class="row mb-4">
            <div class="col-md-4">
                <small class="text-muted d-block">No. Pesanan:</small>
                <strong>#{{ $invoice->id }}</strong>
            </div>
            <div class="cart-header">
                <h3>Rincian Pesanan #{{ $invoice->id }}</h3>
                <small>Tanggal: {{ \Carbon\Carbon::parse($invoice->tgl_penjualan)->format('d/m/Y') }}</small>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Metode Pembayaran:</small>
                <strong>{{ $invoice->metode_bayar->metode_pembayaran ?? '-' }}</strong>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th width="10%">Qty</th>
                        <th>Description</th>
                        <th class="text-center">Price</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->detail_penjualan as $item)
                    <tr>
                        <td class="text-center"><strong>{{ $item->jumlah_beli }}</strong></td>
                        <td>
                            <strong>{{ $item->obat->nama_obat ?? '-' }}</strong><br>
                            {{-- <small class="text-muted">Item ID: {{ $item->obat->id ?? 'N/A' }}</small> --}}
                        </td>
                        <td class="text-center">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end mt-4">
            <div class="col-md-6">
                <div class="total-banner">
                    <span>Subtotal Produk</span>
                    <span>Rp {{ number_format($invoice->detail_penjualan->sum('subtotal'), 0, ',', '.') }}</span>
                </div>
                <div class="p-3 border-bottom d-flex justify-content-between">
                    <span>Ongkos Kirim ({{ $invoice->jenis_kirim->nama_ekspedisi ?? '-' }})</span>
                    <span>Rp {{ number_format($invoice->ongkos_kirim, 0, ',', '.') }}</span>
                </div>
                <div class="p-3 border-bottom d-flex justify-content-between">
                    <span>Biaya Aplikasi</span>
                    <span>Rp {{ number_format($invoice->biaya_app ?? 0, 0, ',', '.') }}</span>
                </div>
                
                <div class="final-amount-box mt-4">
                    <small class="text-uppercase fw-bold">Total Pembayaran</small>
                    <h2>Rp {{ number_format($invoice->total_bayar, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-7">
                <h5 class="fw-bold">Terms & Conditions</h5>
                <p class="small text-muted">
                    Status Order: {{ $invoice->status_order ?? '-' }} | Status Bayar: {{ $invoice->status_pembayaran ?? '-' }}<br>
                    Keterangan: {{ $invoice->keterangan_status ?? '-' }}
                </p>

                @if($invoice->url_resep)
                <div class="alert alert-info py-2">
                    <strong>Resep Dokter:</strong> 
                    <a href="{{ asset($invoice->url_resep) }}" target="_blank">Lihat Resep</a>
                </div>
                @endif

                @if(isset($pengiriman) && $pengiriman)
                <div class="mt-3">
                    <h6 class="fw-bold">Informasi Pengiriman</h6>
                    <p class="small">
                        Kurir: {{ $pengiriman->nama_kurir ?? '-' }} ({{ $pengiriman->telpon_kurir ?? '-' }})<br>
                        Status: {{ $pengiriman->status_kirim ?? '-' }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
            <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">Kembali Berbelanja</a>
             <a href="{{ route('invoice.show', $invoice->id) }}" class="btn btn-success px-4">
                <i class="fas fa-receipt"></i> Lihat Invoice
            </a>
            <a href="{{ route('user.orders') }}" class="btn btn-primary px-4">Riwayat Pesanan</a>
        </div>
    </div>
</div>
@endsection