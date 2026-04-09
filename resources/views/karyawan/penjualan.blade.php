{{-- resources/views/penjualan/index.blade.php --}}
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
                    <h4>Data Penjualan</h4>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Penjualan</h4>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pelanggan</th>
                                        <th>Total Bayar</th>
                                        <th>Status Order</th>
                                        <th>Metode Bayar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penjualan as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($item->tgl_penjualan)
                                                {{ date('d/m/Y', strtotime($item->tgl_penjualan)) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->pelanggan->nama_pelanggan ?? '-' }}</td>
                                        <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
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
                                                $color = $statusColors[$item->status_order] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $color }}">{{ $item->status_order }}</span>
                                            @if($item->keterangan_status)
                                                <br><small class="text-muted">{{ $item->keterangan_status }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $item->metode_bayar->nama_metode ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('penjualan.show', $item->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                
                                                @if($item->status_order == 'Menunggu Konfirmasi')
                                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#approveModal{{ $item->id }}">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#cancelModal{{ $item->id }}">
                                                        <i class="fas fa-times"></i> Batal
                                                    </button>
                                                @endif
                                                
                                                @if($item->status_order == 'Diproses')
                                                    <form action="{{ route('penjualan.updateStatus', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status_order" value="Menunggu Kurir">
                                                        <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Pesanan siap dikirim?')">
                                                            <i class="fas fa-truck"></i> Siap Kirim
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Modal Approve -->
                                    <div class="modal fade" id="approveModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('penjualan.approve', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Approve Penjualan</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menyetujui penjualan ini?</p>
                                                        <p><strong>Total:</strong> Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</p>
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
                                    <div class="modal fade" id="cancelModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('penjualan.cancel', $item->id) }}" method="POST">
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection