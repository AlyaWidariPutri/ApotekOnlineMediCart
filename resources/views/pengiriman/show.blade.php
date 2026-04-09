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
                    <h4>Detail Pengiriman #{{ $pengiriman->id }}</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Pengiriman</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr><th>ID Pengiriman</th><td>#{{ $pengiriman->id }}</td></tr>
                            <tr><th>No Invoice</th><td>{{ $pengiriman->no_invoice }}</td></tr>
                            <tr><th>ID Penjualan</th><td>#{{ $pengiriman->id_penjualan }}</td></tr>
                            <tr><th>Status Kirim</th>
                                <td>
                                    @if($pengiriman->status_kirim == 'Sedang Dikirim')
                                        <span class="badge badge-warning">🚚 Sedang Dikirim</span>
                                    @elseif($pengiriman->status_kirim == 'Tiba di Tujuan')
                                        <span class="badge badge-success">✅ Tiba di Tujuan</span>
                                    @else
                                        <span class="badge badge-secondary">⏳ Belum Dikirim</span>
                                    @endif
                                 </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Kurir</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr><th>Nama Kurir</th><td>{{ $pengiriman->nama_kurir }}</td></tr>
                            <tr><th>Telepon</th><td>{{ $pengiriman->telpon_kurir }}</td></tr>
                            <tr><th>Tgl Kirim</th><td>{{ $pengiriman->tgl_kirim ? date('d/m/Y H:i', strtotime($pengiriman->tgl_kirim)) : '-' }}</td></tr>
                            <tr><th>Tgl Tiba</th><td>{{ $pengiriman->tgl_tiba ? date('d/m/Y H:i', strtotime($pengiriman->tgl_tiba)) : '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if($pengiriman->keterangan)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Keterangan</h4>
                    </div>
                    <div class="card-body">
                        <p>{{ $pengiriman->keterangan }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($pengiriman->bukti_foto)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bukti Pengiriman</h4>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/'.$pengiriman->bukti_foto) }}" alt="Bukti Pengiriman" class="img-fluid" style="max-width: 500px;">
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection