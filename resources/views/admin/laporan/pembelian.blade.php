@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection

@section('navbar')
    @include('be.navbar')
@endsection


@section('content')
<div class="container" style="margin-left: 230px; margin-top: 70px; padding: 20px;">
    <h2>Laporan Pembelian</h2>
    
    <!-- Filter Form -->
    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="month" name="periode" class="form-control" 
                       value="{{ request('periode') ?? date('Y-m') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('laporan.pembelian') }}" class="btn btn-secondary">Reset</a>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('laporan.pembelian.pdf') }}?periode={{ request('periode') }}" 
                class="btn btn-success">
                    Download PDF
                </a>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No. Nota</th>
                    <th>Tanggal</th>
                    <th>Distributor</th>
                    <th>Total</th>
                    <th>Detail Obat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelian as $item)
                <tr>
                    <td>{{ $item->nonota }}</td>
                    <td>{{ $item->tgl_pembelian->format('d/m/Y') }}</td>
                    <td>{{ $item->distributor->nama_distributor }}</td>
                    <td>Rp {{ number_format($item->total_bayar, 0) }}</td>
                    <td>
                        <ul>
                            @forelse($item->details ?? [] as $detail)
                            <li>
                                {{ $detail->obat->nama_obat }} -
                                {{ $detail->jumlah_beli }} pcs ×
                                Rp {{ number_format($detail->harga_beli, 0) }}
                            </li>
                            @empty
                            <li>Tidak ada detail obat</li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection