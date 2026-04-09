<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembelian {{ $bulan }}/{{ $tahun }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
        }
        .header h2 {
            margin-bottom: 5px;
        }
        .header h3 {
            margin-top: 0;
            color: #555;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 8px; 
            text-align: left; 
            vertical-align: top;
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
        .grand-total {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .detail-obat {
            margin: 0;
            padding-left: 15px;
        }
        .detail-obat li {
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pembelian</h2>
        <h3>Bulan {{ $bulan }}/{{ $tahun }}</h3>
        <p>Dicetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">No. Nota</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Distributor</th>
                <th width="13%">Total Bayar</th>
                <th width="45%">Detail Obat</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($pembelian as $index => $item)
            @php $grandTotal += $item->total_bayar; @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nonota }}</td>
                <td>{{ $item->tgl_pembelian->format('d/m/Y') }}</td>
                <td>{{ $item->distributor->nama_distributor }}</td>
                <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                <td>
                    @foreach($item->details as $detail)
                        • {{ $detail->obat->nama_obat }}: 
                        {{ $detail->jumlah_beli }} pcs × 
                        Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}
                        = Rp {{ number_format($detail->subtotal, 0, ',', '.') }}<br>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="grand-total">
                <td colspan="4" style="text-align: right;"><strong>GRAND TOTAL</strong></td>
                <td colspan="2"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
    
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem</p>
    </div>
</body>
</html>