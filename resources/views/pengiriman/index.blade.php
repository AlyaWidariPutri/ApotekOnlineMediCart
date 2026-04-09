{{-- resources/views/pengiriman/index.blade.php --}}
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
                    <h4>Data Pengiriman</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="{{ route('pengiriman.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pengiriman
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
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
                                        <th>No Invoice</th>
                                        <th>Penjualan ID</th>
                                        <th>Nama Kurir</th>
                                        <th>Telepon</th>
                                        <th>Tgl Kirim</th>
                                        <th>Tgl Tiba</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengiriman as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->no_invoice }}</td>
                                        <td>#{{ $item->id_penjualan }}</td>
                                        <td>{{ $item->nama_kurir }}</td>
                                        <td>{{ $item->telpon_kurir }}</td>
                                        <td>{{ $item->tgl_kirim ? date('d/m/Y H:i', strtotime($item->tgl_kirim)) : '-' }}</td>
                                        <td>{{ $item->tgl_tiba ? date('d/m/Y H:i', strtotime($item->tgl_tiba)) : '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $item->status_kirim == 'Sedang Dikirim' ? 'warning' : 'success' }}">
                                                {{ $item->status_kirim ?? 'Belum Dikirim' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('pengiriman.show', $item->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('pengiriman.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                @if($item->status_kirim == 'Sedang Dikirim')
                                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#statusModal{{ $item->id }}">
                                                        <i class="fas fa-check"></i> Tiba
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Modal Update Status -->
                                    <div class="modal fade" id="statusModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('pengiriman.updateStatus', $item->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Status Pengiriman</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="status_kirim" value="Tiba di Tujuan">
                                                        <div class="form-group">
                                                            <label>Upload Bukti Foto</label>
                                                            <input type="file" name="bukti_foto" class="form-control" accept="image/*">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">Konfirmasi Tiba</button>
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