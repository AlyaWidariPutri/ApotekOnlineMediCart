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
                    <h4>Edit Jenis Obat</h4>
                    <span class="ml-1">Perbarui data jenis obat</span>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('jenis_obat.update', $jenisObat->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group">
                                    <label>Jenis Obat</label>
                                    <input type="text" name="jenis" class="form-control" value="{{ $jenisObat->jenis }}" maxlength="50" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Deskripsi Jenis Obat</label>
                                    <textarea name="deskripsi_jenis" class="form-control" maxlength="255" rows="3" required>{{ $jenisObat->deskripsi_jenis }}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Gambar</label>
                                    @if($jenisObat->image_url)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/'.$jenisObat->image_url) }}" width="100" class="img-thumbnail">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="old_image" value="1" checked>
                                                <label class="form-check-label">Gunakan gambar ini</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="image_url" class="form-control-file">
                                </div>
                                
                                <div class="text-end">
                                    <a href="{{ route('jenis_obat.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-window-close me-2"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Simpan Perubahan
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