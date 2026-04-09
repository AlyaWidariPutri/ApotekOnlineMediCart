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
                    <h4>Tambah Jenis Obat Baru</h4>
                    <span class="ml-1">Isi data jenis obat dengan benar</span>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('jenis_obat.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Jenis Obat</label>
                                    <input type="text" name="jenis" class="form-control" maxlength="50" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Deskripsi Jenis Obat</label>
                                    <textarea name="deskripsi_jenis" class="form-control" maxlength="255" rows="3" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Gambar</label>
                                    <input type="file" name="image_url" class="form-control-file" required>
                                </div>
                                
                                <div class="text-end">
                                    <a href="{{ route('jenis_obat.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-window-close me-2"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Simpan Jenis Obat Baru
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection