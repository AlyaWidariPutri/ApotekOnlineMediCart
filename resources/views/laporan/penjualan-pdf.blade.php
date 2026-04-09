<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Penjualan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #333; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .filter-info { margin-bottom: 20px; padding: 10px; background: #f5f5f5; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #0d6efd; color: white; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; padding: 10px; border-top: 1px solid #ddd; }
        .total-row { background-color: #f0f0f0; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p>MediCart - Apotek Online Terpercaya</p>
        <p>Jl. Kesehatan No. 123, Jakarta | Telp: (021) 1234-5678</p>
    </div>

    <div class="filter-info">
        <strong>Periode:</strong> 
        @if(isset($start_date) && isset($end_date) && $start_date && $end_date)
            {{ date('d/m/Y', strtotime($start_date)) }} - {{ date('d/m/Y', strtotime($end_date)) }}
        @elseif(isset($start_date) && $start_date)
            Mulai dari {{ date('d/m/Y', strtotime($start_date)) }}
        @elseif(isset($end_date) && $end_date)
            Sampai {{ date('d/m/Y', strtotime($end_date)) }}
        @else
            Semua Periode
        @endif
        <br>
        <strong>Status:</strong> {{ $status ?? 'Semua Status' }}
        <br>
        <strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i:s') }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tanggal</th>
                <th>No. Invoice</th>
                <th>Pelanggan</th>
                <th class="text-right">Total Bayar</th>
                <th>Status</th>
                <th>Metode Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_penjualan)->format('d/m/Y H:i') }}</td>
                <td>#{{ $item->id }}</td>
                <td>{{ $item->pelanggan->nama_pelanggan ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                <td>{{ $item->status_order }}</td>
                <td>{{ $item->metode_bayar->metode_pembayaran ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }} | Laporan Penjualan - MediCart
    </div>
</body>
</html>