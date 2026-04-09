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
                    <h4>Payment Method Details</h4>
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
                                <label class="col-sm-3 col-form-label">Payment Method</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" 
                                           value="{{ $metodeBayar->metode_pembayaran }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Payment Station</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" 
                                           value="{{ $metodeBayar->tempat_bayar }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Account Number</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" 
                                           value="{{ $metodeBayar->no_rekening ?? '-' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Logo</label>
                                <div class="col-sm-9">
                                    @if($metodeBayar->url_logo)
                                        <img src="{{ $metodeBayar->url_logo }}" width="100" alt="Logo">
                                    @else
                                        <span>-</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <a href="{{ route('metode_bayar.index') }}" class="btn btn-light">
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