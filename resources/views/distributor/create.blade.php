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
                    <h4>Tambah Distributor</h4>
                    <span class="ml-1">Isi data distributor dengan benar</span>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-6 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Distributor</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('distributor.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Nama Distributor</label>
                                    <input type="text" class="form-control" name="nama_distributor" placeholder="Nama distributor" required>
                                </div>
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input type="text" class="form-control" name="telepon" placeholder="Nomor telepon" required>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" rows="3" required></textarea>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('distributor.index')}}" class="btn btn-secondary">
                                        <i class="fas fa-window-close me-2"></i> Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Simpan
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