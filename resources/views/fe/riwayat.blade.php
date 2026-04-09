@extends('fe.master')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Riwayat Pesanan Saya</h3>
        </div>
        
        <div class="card-body">
            @if($pesanan->isEmpty())
                <div class="alert alert-info text-center">
                    <p>Belum ada pesanan. Yuk belanja dulu!</p>
                    <a href="{{ route('home.index') }}" class="btn btn-primary">Mulai Belanja</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-primary">
                                <th>No. Invoice</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status Order</th>
                                <th>Status Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan as $p)
                            <tr>
                                <td>#{{ $p->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tgl_penjualan)->format('d/m/Y H:i') }}</td>
                                <td>Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'Menunggu Konfirmasi' => 'warning',
                                            'Diproses' => 'info',
                                            'Dikirim' => 'primary',
                                            'Selesai' => 'success',
                                            'Dibatalkan' => 'danger'
                                        ];
                                        $class = $statusClass[$p->status_order] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $class }}">{{ $p->status_order }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $p->status_pembayaran == 'Lunas' ? 'success' : 'warning' }}">
                                        {{ $p->status_pembayaran ?? 'Belum Dibayar' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('invoice.show', $p->id) }}" class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection