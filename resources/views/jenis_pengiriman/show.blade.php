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
                    <h4>Shipping Method Details</h4>
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
                                <label class="col-sm-3 col-form-label">Shipping Type</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" 
                                           value="{{ ucfirst($jenisPengiriman->jenis_kirim) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Expedition Name</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" 
                                           value="{{ $jenisPengiriman->nama_ekspedisi }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Price</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" 
                                           value="{{ $jenisPengiriman->harga }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Expedition Logo</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" 
                                           value="{{ $jenisPengiriman->logo_ekspedisi }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <a href="{{ route('jenis_pengiriman.index') }}" class="btn btn-light">
                                        <i class="fas fa-arrow-left me-2"></i> Back
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