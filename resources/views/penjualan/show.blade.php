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
                    <h4>Detail Penjualan #{{ $penjualan->id }}</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Informasi Pesanan -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="card-title">Informasi Pesanan</h5>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="150">No. Invoice</td>
                                        <td><strong>#{{ $penjualan->id }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>{{ \Carbon\Carbon::parse($penjualan->tgl_penjualan)->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Order</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'Menunggu Konfirmasi' => 'warning',
                                                    'Diproses' => 'info',
                                                    'Menunggu Kurir' => 'primary',
                                                    'Sedang Dikirim' => 'info',
                                                    'Dibatalkan Pembeli' => 'danger',
                                                    'Dibatalkan Penjual' => 'danger',
                                                    'Bermasalah' => 'danger',
                                                    'Selesai' => 'success'
                                                ];
                                                $color = $statusColors[$penjualan->status_order] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $color }}">{{ $penjualan->status_order }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Pembayaran</td>
                                        <td>
                                            <span class="badge {{ $penjualan->status_pembayaran == 'Lunas' ? 'badge-success' : 'badge-warning' }}">
                                                {{ $penjualan->status_pembayaran ?? 'Belum Dibayar' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Metode Pembayaran</td>
                                        <td>{{ $penjualan->metode_bayar->metode_pembayaran ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>{{ $penjualan->keterangan_status ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="col-md-6">
                                <h5 class="card-title">Informasi Pelanggan</h5>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="150">Nama</td>
                                        <td><strong>{{ $penjualan->pelanggan->nama_pelanggan ?? '-' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $penjualan->pelanggan->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. Telepon</td>
                                        <td>{{ $penjualan->pelanggan->no_telp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Penerima</td>
                                        <td>{{ $penjualan->nama_penerima ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Pengiriman</td>
                                        <td>{{ $penjualan->alamat_pengiriman ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. HP Penerima</td>
                                        <td>{{ $penjualan->no_hp_penerima ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Detail Produk -->
                        <h5 class="card-title mt-4">Detail Produk</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Obat</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penjualan->detail_penjualan as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->obat->nama_obat ?? '-' }}</td>
                                        <td class="text-center">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->jumlah_beli }}</td>
                                        <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="4" class="text-end fw-bold">SUBTOTAL</td>
                                        <td class="text-end">Rp {{ number_format($penjualan->detail_penjualan->sum('subtotal'), 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">Ongkos Kirim</td>
                                        <td class="text-end">Rp {{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">Biaya Aplikasi</td>
                                        <td class="text-end">Rp {{ number_format($penjualan->biaya_app ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="4" class="text-end">TOTAL</td>
                                        <td class="text-end">Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Informasi Pengiriman -->
                        @if(isset($penjualan->pengiriman) && $penjualan->pengiriman)
                        <div class="mt-4">
                            <h5 class="card-title">Informasi Pengiriman</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="150">Kurir</td>
                                    <td>{{ $penjualan->pengiriman->nama_kurir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Telepon Kurir</td>
                                    <td>{{ $penjualan->pengiriman->telpon_kurir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Status Kirim</td>
                                    <td>{{ $penjualan->pengiriman->status_kirim ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        @endif

                        <!-- Resep -->
                        @if($penjualan->url_resep)
                        <div class="mt-4">
                            <h5 class="card-title">Resep Dokter</h5>
                            <a href="{{ asset($penjualan->url_resep) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-file-image"></i> Lihat Resep
                            </a>
                        </div>
                        @endif

                        <!-- Bukti Transfer -->
                        @if($penjualan->bukti_transfer)
                        <div class="mt-4">
                            <h5 class="card-title">Bukti Transfer</h5>
                            <a href="{{ asset($penjualan->bukti_transfer) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-receipt"></i> Lihat Bukti Transfer
                            </a>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="mt-4">
                            @if($penjualan->status_order == 'Menunggu Konfirmasi')
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#approveModal">
                                    <i class="fas fa-check"></i> Approve Pesanan
                                </button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelModal">
                                    <i class="fas fa-times"></i> Batalkan Pesanan
                                </button>
                            @endif
                            
                            @if($penjualan->status_order == 'Diproses')
                                <form action="{{ route('penjualan.updateStatus', $penjualan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_order" value="Menunggu Kurir">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Pesanan siap dikirim?')">
                                        <i class="fas fa-truck"></i> Siap Kirim
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('penjualan.approve', $penjualan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Approve Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui penjualan ini?</p>
                    <p><strong>Total:</strong> Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Cancel -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('penjualan.cancel', $penjualan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Batalkan Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin membatalkan penjualan ini?</p>
                    <p class="text-danger">Stok akan dikembalikan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection