@extends('fe.master')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container-fluid py-5 px-4" style="min-height: 70vh;"> 
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4 fw-bold">Riwayat Pesanan</h2>
            
            <div class="table-responsive">
                <table class="table table-lg table-hover"> 
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">No. Invoice</th> 
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="py-3 px-4 align-middle">{{ $order->id }}</td> 
                            <td class="py-3 px-4 align-middle">{{ \Carbon\Carbon::parse($order->tgl_penjualan)->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 align-middle">
                                <span class="badge bg-warning text-dark">{{ $order->status_order }}</span>
                            </td>
                            <td class="py-3 px-4 align-middle">Rp {{ number_format($order->total_bayar, 0) }}</td>
                            <td class="py-3 px-4 align-middle">
                                <a href="{{ route('checkout.summary', $order->id) }}" 
                                    class="btn btn-sm rounded-pill px-3" 
                                    style="background-color: #F28123; border-color: #F28123; color: white;">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection