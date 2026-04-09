@extends('be.master')

@section('sidebar')
    @include('be.sidebar')
@endsection

@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div class="container" style="margin-left: 230px; margin-top: 70px; padding: 20px;">
    <h2>Daftar Pembelian</h2>
    <a href="{{ route('apoteker.pembelian.create') }}" class="btn btn-primary mb-3">Tambah Pembelian</a>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No. Nota</th>
                    <th>Tanggal</th>
                    <th>Distributor</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelians as $pembelian)
                <tr>
                    <td>{{ $pembelian->nonota }}</td>
                    <td>{{ $pembelian->tgl_pembelian->format('d/m/Y') }}</td>
                    <td>{{ $pembelian->distributor->nama_distributor }}</td>
                    <td>Rp {{ number_format($pembelian->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('apoteker.pembelian.show', $pembelian->id) }}" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection