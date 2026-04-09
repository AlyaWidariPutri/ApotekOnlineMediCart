@extends('be.master')

@section('sidebar')
    @include('be.sidebar')
@endsection

@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Laporan Keuangan Apotek</h2>

    <table id="financeTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Metode Pembayaran</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id_penjualan }}</td>
                <td>{{ $transaction->created_at }}</td>
                <td>{{ $transaction->metode_bayar }}</td>
                <td>Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="mt-4">Total Pendapatan: Rp {{ number_format($totalIncome, 0, ',', '.') }}</h4>
</div>

<script>
    $(document).ready(function() {
        $('#financeTable').DataTable();
    });
</script>
@endsection
