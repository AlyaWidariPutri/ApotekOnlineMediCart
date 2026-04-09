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
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Card -->
                <div class="card">
                    <div class="card-body text-center">
                        @if($pelanggan->foto)
                            <img src="{{ asset($pelanggan->foto) }}" alt="Foto Profil" class="rounded-circle" width="150" height="150" style="object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-4x text-white"></i>
                            </div>
                        @endif
                        <h4 class="mt-3">{{ $pelanggan->nama_pelanggan }}</h4>
                        <p class="text-muted">{{ $pelanggan->email }}</p>
                        <p><i class="fas fa-phone"></i> {{ $pelanggan->no_telp ?? 'Belum diisi' }}</p>
                        
                        @if($pelanggan->url_ktp)
                            <a href="{{ asset('storage/' . $pelanggan->url_ktp) }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-id-card"></i> Lihat KTP
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <!-- Address Card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Alamat Pelanggan</h5>
                    </div>
                    <div class="card-body">
                        <!-- Alamat 1 -->
                        <div class="mb-4">
                            <h6>Alamat Utama</h6>
                            <p class="mb-1">{{ $pelanggan->alamat1 ?? '-' }}</p>
                            <p class="mb-0 text-muted">
                                {{ $pelanggan->kota1 ?? '-' }}, {{ $pelanggan->propinsi1 ?? '-' }} - {{ $pelanggan->kodepos1 ?? '-' }}
                            </p>
                        </div>
                        
                        <!-- Alamat 2 -->
                        @if($pelanggan->alamat2)
                        <div class="mb-4">
                            <h6>Alamat Kedua</h6>
                            <p class="mb-1">{{ $pelanggan->alamat2 }}</p>
                            <p class="mb-0 text-muted">
                                {{ $pelanggan->kota2 }}, {{ $pelanggan->propinsi2 }} - {{ $pelanggan->kodepos2 }}
                            </p>
                        </div>
                        @endif
                        
                        <!-- Alamat 3 -->
                        @if($pelanggan->alamat3)
                        <div class="mb-4">
                            <h6>Alamat Ketiga</h6>
                            <p class="mb-1">{{ $pelanggan->alamat3 }}</p>
                            <p class="mb-0 text-muted">
                                {{ $pelanggan->kota3 }}, {{ $pelanggan->propinsi3 }} - {{ $pelanggan->kodepos3 }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Info Akun -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Informasi Akun</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="200">Bergabung Sejak</th>
                                <td>{{ $pelanggan->created_at ? $pelanggan->created_at->format('d F Y H:i:s') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Terakhir Diupdate</th>
                                <td>{{ $pelanggan->updated_at ? $pelanggan->updated_at->format('d F Y H:i:s') : '-' }}</td>
                            </tr>
                            {{-- <tr>
                                <th>Status</th>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <a href="{{ route('admin.customers') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection