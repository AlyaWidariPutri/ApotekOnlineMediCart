<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body { 
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            background: #fff;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background: #fff;
        }
        /* Header */
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #4a90e2;
            padding-bottom: 20px;
        }
        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #4a90e2;
            margin-bottom: 10px;
        }
        .invoice-number {
            font-size: 14px;
            color: #666;
        }
        .store-info {
            text-align: right;
        }
        .store-name {
            font-size: 18px;
            font-weight: bold;
            color: #4a90e2;
        }
        /* Info Boxes */
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 14px;
            color: #4a90e2;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }
        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table th {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #dee2e6;
        }
        .table td {
            padding: 8px 10px;
            border: 1px solid #dee2e6;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .fw-bold {
            font-weight: bold;
        }
        /* Total Row */
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }
        .thankyou {
            font-size: 16px;
            font-weight: bold;
            color: #4a90e2;
            margin-bottom: 10px;
        }
        .signature {
            margin-top: 20px;
            font-style: italic;
            color: #666;
        }
        /* Badge */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 4px;
        }
        .badge-success {
            background-color: #28a745;
            color: #fff;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }
        .badge-primary {
            background-color: #4a90e2;
            color: #fff;
        }
        .badge-info {
            background-color: #17a2b8;
            color: #fff;
        }
        .row {
            margin-bottom: 20px;
            overflow: hidden;
        }
        .col-6 {
            width: 48%;
            float: left;
        }
        .col-6:last-child {
            float: right;
        }
        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="row">
                <div class="col-6">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-number">
                        <strong>INVOICE #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</strong><br>
                        DATE: {{ \Carbon\Carbon::parse($invoice->tgl_penjualan)->format('M d, Y') }}
                    </div>
                </div>
                <div class="col-6">
                    <div class="store-info">
                        <div class="store-name">APOTEK SEHAT</div>
                        <div>www.apoteksehat.com</div>
                        <div>021 - 1234 5678</div>
                        <div>Jl. Kesehatan No. 123, Jakarta</div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Info Pelanggan & Pengiriman -->
        <div class="row">
            <div class="col-6">
                <div class="info-box">
                    <div class="info-title">INFORMASI PELANGGAN</div>
                    <div><strong>{{ $invoice->pelanggan->nama_pelanggan }}</strong></div>
                    <div>{{ $invoice->pelanggan->email }}</div>
                    <div>{{ $invoice->pelanggan->no_telp }}</div>
                </div>
            </div>
            <div class="col-6">
                <div class="info-box">
                    <div class="info-title">INFORMASI PENGIRIMAN</div>
                    <div><strong>Penerima:</strong> {{ $invoice->nama_penerima }}</div>
                    <div><strong>Alamat:</strong> {{ $invoice->alamat_pengiriman }}</div>
                    <div><strong>Telepon:</strong> {{ $invoice->no_hp_penerima }}</div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Tabel Produk -->
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 50%">PRODUCT</th>
                    <th style="width: 15%" class="text-right">PRICE</th>
                    <th style="width: 10%" class="text-center">QTY</th>
                    <th style="width: 20%" class="text-right">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->detail_penjualan as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->obat->nama_obat }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item->jumlah_beli }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right fw-bold">SUBTOTAL</td>
                    <td class="text-right">Rp {{ number_format($invoice->detail_penjualan->sum('subtotal'), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">Ongkos Kirim</td>
                    <td class="text-right">Rp {{ number_format($invoice->ongkos_kirim, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">Biaya Aplikasi</td>
                    <td class="text-right">Rp {{ number_format($invoice->biaya_app ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" class="text-right fw-bold">TOTAL</td>
                    <td class="text-right fw-bold">Rp {{ number_format($invoice->total_bayar, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Info Pembayaran & Status -->
        <div class="row">
            <div class="col-6">
                <div class="info-box">
                    <div class="info-title">METODE PEMBAYARAN</div>
                    <div>{{ $invoice->metode_bayar->metode_pembayaran }}</div>
                    <div>
                        Status: 
                        <span class="badge {{ $invoice->status_pembayaran == 'Lunas' ? 'badge-success' : 'badge-warning' }}">
                            {{ $invoice->status_pembayaran ?? 'Belum Dibayar' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="info-box">
                    <div class="info-title">STATUS PESANAN</div>
                    <div>
                        <span class="badge badge-primary">{{ $invoice->status_order }}</span>
                    </div>
                    @if($invoice->status_resep)
                    <div class="mt-2">
                        Status Resep: 
                        <span class="badge badge-info">{{ $invoice->status_resep }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Footer Terima Kasih -->
        <div class="footer">
            <div class="thankyou">THANK YOU FOR YOUR ORDER!</div>
            <div>
                This is a signature of our customer. We are happy to have served you and wish you all the best.<br>
                We will continue to provide high quality medicine and service. Thank you for choosing us.
            </div>
            <div class="signature">
                <i class="fas fa-heart"></i> <i class="fas fa-star"></i> <i class="fas fa-smile"></i>
            </div>
        </div>
    </div>
</body>
</html>