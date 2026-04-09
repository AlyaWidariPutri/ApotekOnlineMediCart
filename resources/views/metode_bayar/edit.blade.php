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
                    <h4>Edit Payment Method</h4>
                    <span class="ml-1">Update payment method details</span>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-6 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Payment Method Form</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('metode_bayar.update',$metodeBayar->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <input type="text" class="form-control" name="metode_pembayaran" 
                                           value="{{ $metodeBayar->metode_pembayaran }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Payment Station</label>
                                    <input type="text" class="form-control" name="tempat_bayar" 
                                           value="{{ $metodeBayar->tempat_bayar }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="no_rekening" 
                                           value="{{ $metodeBayar->no_rekening }}">
                                </div>
                                <div class="form-group">
                                    <label>Logo URL</label>
                                    <input type="text" class="form-control" name="url_logo" 
                                           value="{{ $metodeBayar->url_logo }}">
                                </div>
                                <div class="text-end">
                                    <a href="{{route('metode_bayar.index')}}" class="btn btn-secondary">
                                        <i class="fas fa-window-close me-2"></i> Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Update Payment Method
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