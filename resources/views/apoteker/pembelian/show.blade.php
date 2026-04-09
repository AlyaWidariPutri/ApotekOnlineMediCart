@extends('be.master')

@section('sidebar')
    @include('be.sidebar')
@endsection

@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div class="container" style="margin-left: 230px; margin-top: 70px; padding: 20px;">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Detail Pembelian</h4>
            <a href="{{ route('apoteker.pembelian.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">No. Nota</th>
                            <td>{{ $pembelian->nonota }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pembelian</th>
                            <td>{{ $pembelian->tgl_pembelian->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Distributor</th>
                            <td>{{ $pembelian->distributor->nama }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Total Pembelian</th>
                            <td>Rp {{ number_format($pembelian->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Item</th>
                            <td>{{ $pembelian->details->count() }} jenis obat</td>
                        </tr>
                    </table>
                </div>
            </div>

            <h5 class="mb-3">Daftar Obat</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Harga Beli</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelian->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->obat->nama_obat }}</td>
                            <td>{{ $detail->jumlah_beli }}</td>
                            <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">Total</td>
                            <td>Rp {{ number_format($pembelian->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection