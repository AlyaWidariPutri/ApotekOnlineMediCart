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
        <!-- Dashboard Title Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">Cashier Dashboard</h4>
                            <div class="text-muted small">Last updated: <span id="current-time">{{ now()->format('d M Y H:i:s') }}</span></div>
                        </div>
                        <!-- Stats Cards -->
                        <div class="row">
                            <!-- Shipping Methods -->
                            <div class="col-xl-6 col-lg-6 col-sm-6 mb-4">
                                <div class="card hover-scale" style="background-color:rgb(64, 72, 114); border: none; margin-top: 30px;">
                                    <div class="card-body text-white">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white-20 text-white mr-3">
                                                <i class="fas fa-shipping-fast"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-0 text-white">{{ $shippingMethodCount }}</h3>
                                                <span>Shipping Methods</span>
                                                <div class="small opacity-75 mt-1">Updated: {{ $lastShippingMethodUpdate }}</div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('jenis_pengiriman.index') }}" class="text-white d-flex align-items-center">
                                                View all methods <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Methods -->
                            <div class="col-xl-6 col-lg-6 col-sm-6 mb-4">
                                <div class="card hover-scale" style="background-color:rgb(71, 77, 107); border: none; margin-top: 30px;">
                                    <div class="card-body text-white">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white-20 text-white mr-3">
                                                <i class="fas fa-credit-card"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-0 text-white">{{ $paymentMethodCount }}</h3>
                                                <span>Payment Methods</span>
                                                <div class="small opacity-75 mt-1">Updated: {{ $lastPaymentMethodUpdate }}</div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('metode_bayar.index') }}" class="text-white d-flex align-items-center">
                                                View all methods <i class="fas fa-arrow-right ml-2"></i>
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

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-6 mb-4">
                                <a href="{{ route('jenis_pengiriman.create') }}" class="btn btn-block btn-action" style="background-color: rgb(64, 72, 114);">
                                    <i class="fas fa-plus-circle fa-2x mb-2 text-white"></i>
                                    <h5 class="text-white">Add Shipping Method</h5>
                                    <p class="small text-white-75">Create new delivery option</p>
                                </a>
                            </div>
                            <div class="col-md-6 mb-4">
                                <a href="{{ route('jenis_pengiriman.create') }}" class="btn btn-block btn-action" style="background-color: rgb(71, 77, 107);">
                                    <i class="fas fa-credit-card fa-2x mb-2 text-white"></i>
                                    <h5 class="text-white">Add Payment Method</h5>
                                    <p class="small text-white-75">Create new payment option</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Update current time
    function updateCurrentTime() {
        const now = new Date();
        const options = { 
            day: 'numeric', 
            month: 'short', 
            year: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: false,
            timeZone: 'Asia/Jakarta'
        };
        document.getElementById('current-time').textContent = now.toLocaleDateString('en-US', options);
    }
    
    // Update every second
    setInterval(updateCurrentTime, 1000);
    updateCurrentTime();
</script>
@endsection
@endsection