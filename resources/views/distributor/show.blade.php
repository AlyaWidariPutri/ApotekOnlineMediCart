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
                    <h4>Detail Distributor</h4>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-6 col-xxl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Distributor</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" 
                                           value="{{ $distributor->nama_distributor }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Telepon</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" 
                                           value="{{ $distributor->telepon }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <textarea readonly class="form-control-plaintext">{{ $distributor->alamat }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <a href="{{ route('distributor.index') }}" class="btn btn-light">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection