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
                            <h4 class="mb-0">Pharmacist Dashboard</h4>
                            <div class="text-muted small">Last updated: <span id="current-time">{{ now()->format('d M Y H:i:s') }}</span></div>
                        </div>
                        <!-- Stats Cards -->
                        <div class="row">
                            <!-- Total Medicines -->
                            
                            <div class="col-xl-4 col-lg-6 col-sm-6 mb-4">
                                <div class="card hover-scale" style="background-color:rgb(64, 72, 114); border: none; margin-top: 30px;">
                                    <div class="card-body text-white">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white-20 text-white mr-3">
                                                <i class="fas fa-pills"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-0 text-white">{{ $medicineCount }}</h3>
                                                <span>Total Medicines</span>
                                                <div class="small opacity-75 mt-1">Updated: {{ $lastMedicineUpdate }}</div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('obat.index') }}" class="text-white d-flex align-items-center">
                                                View all medicines <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Medicine Types -->
                            <div class="col-xl-4 col-lg-6 col-sm-6 mb-4">
                                <div class="card hover-scale" style="background-color:rgb(71, 77, 107); border: none; margin-top: 30px;">
                                    <div class="card-body text-white">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white-20 text-white mr-3">
                                                <i class="fas fa-tags"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-0 text-white">{{ $medicineTypeCount }}</h3>
                                                <span>Medicine Types</span>
                                                <div class="small opacity-75 mt-1">Updated: {{ $lastTypeUpdate }}</div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('jenis_obat.index') }}" class="text-white d-flex align-items-center">
                                                View all types <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Distributors -->
                            <div class="col-xl-4 col-lg-6 col-sm-6 mb-4">
                                <div class="card hover-scale" style="background-color:rgb(154, 129, 176); border: none; margin-top: 30px;">
                                    <div class="card-body text-white">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white-20 text-white mr-3">
                                                <i class="fas fa-truck"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-0 text-white">{{ $distributorCount }}</h3>
                                                <span>Distributors</span>
                                                <div class="small opacity-75 mt-1">Updated: {{ $lastDistributorUpdate }}</div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('distributor.index') }}" class="text-white d-flex align-items-center">
                                                View all distributors <i class="fas fa-arrow-right ml-2"></i>
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
                            <div class="col-md-4 mb-4">
                                <a href="{{ route('obat.create') }}" class="btn btn-block btn-action" style="background-color: rgb(64, 72, 114);">
                                    <i class="fas fa-plus-circle fa-2x mb-2 text-white"></i>
                                    <h5 class="text-white">Add New Medicine</h5>
                                    <p class="small text-white-75">Register new medicine to inventory</p>
                                </a>
                            </div>
                            <div class="col-md-4 mb-4">
                                <a href="{{ route('jenis_obat.create') }}" class="btn btn-block btn-action" style="background-color: rgb(71, 77, 107);">
                                    <i class="fas fa-tags fa-2x mb-2 text-white"></i>
                                    <h5 class="text-white">Add Medicine Type</h5>
                                    <p class="small text-white-75">Create new medicine category</p>
                                </a>
                            </div>
                            <div class="col-md-4 mb-4">
                                <a href="{{ route('distributor.create') }}" class="btn btn-block btn-action" style="background-color: rgb(154, 129, 176);">
                                    <i class="fas fa-truck-loading fa-2x mb-2 text-white"></i>
                                    <h5 class="text-white">Add Distributor</h5>
                                    <p class="small text-white-75">Register new supplier</p>
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