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
                            <h4 class="mb-0">Owner Dashboard</h4>
                            <div class="text-muted small">Last updated: <span id="current-time">{{ now()->format('d M Y H:i:s') }}</span></div>
                        </div>
                        <!-- Stats Cards -->
                        <div class="row">
                            <!-- Laporan Pembelian -->
                            <div class="col-xl-6 col-lg-6 col-sm-6 mb-4">
                                <div class="card hover-scale" style="background-color:rgb(64, 72, 114); border: none; margin-top: 30px;">
                                    <div class="card-body text-white">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white-20 text-white mr-3">
                                                <i class="fas fa-file-invoice"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-0 text-white">{{ $purchaseReportCount ?? 0 }}</h3>
                                                <span>Laporan Pembelian</span>
                                                <div class="small opacity-75 mt-1">Total data pembelian</div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('laporan.pembelian') }}" class="text-white d-flex align-items-center">
                                                View all reports <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Users -->
                            <div class="col-xl-6 col-lg-6 col-sm-6 mb-4">
                                <div class="card hover-scale" style="background-color:rgb(71, 77, 107); border: none; margin-top: 30px;">
                                    <div class="card-body text-white">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white-20 text-white mr-3">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-0 text-white">{{ $totalUsers ?? 0 }}</h3>
                                                <span>Data Users</span>
                                                <div class="small opacity-75 mt-1">Total karyawan & staff</div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('pemilik.users') }}" class="text-white d-flex align-items-center">
                                                View all users <i class="fas fa-arrow-right ml-2"></i>
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
                                <a href="{{ route('laporan.pembelian') }}" class="btn btn-block btn-action" style="background-color: rgb(64, 72, 114);">
                                    <i class="fas fa-chart-line fa-2x mb-2 text-white"></i>
                                    <h5 class="text-white">Laporan Pembelian</h5>
                                    <p class="small text-white-75">Lihat laporan pembelian obat</p>
                                </a>
                            </div>
                            <div class="col-md-6 mb-4">
                                <a href="{{ route('pemilik.users') }}" class="btn btn-block btn-action" style="background-color: rgb(71, 77, 107);">
                                    <i class="fas fa-user-cog fa-2x mb-2 text-white"></i>
                                    <h5 class="text-white">Kelola Users</h5>
                                    <p class="small text-white-75">Lihat data semua user</p>
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