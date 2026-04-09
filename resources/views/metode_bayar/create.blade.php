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
                    <h4>Payment Method</h4>
                    <span class="ml-1">Fill in the payment method correctly</span>
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
                            <form action="{{ route('metode_bayar.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <input type="text" class="form-control" name="metode_pembayaran" placeholder="e.g. Bank Transfer, E-Wallet" required>
                                </div>
                                <div class="form-group">
                                    <label>Payment Station</label>
                                    <input type="text" class="form-control" name="tempat_bayar" placeholder="e.g. BCA, OVO, Gopay" required>
                                </div>
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control" name="no_rekening" placeholder="Optional">
                                </div>
                                <div class="form-group">
                                    <label>Logo URL</label>
                                    <input type="text" class="form-control" name="url_logo" placeholder="Optional image URL">
                                </div>
                                <div class="text-end">
                                    <a href="{{route('metode_bayar.index')}}" class="btn btn-secondary">
                                        <i class="fas fa-window-close me-2"></i> Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Save Payment Method
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