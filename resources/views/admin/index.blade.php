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
                            <h4 class="mb-0">Admin Dashboard - User Management</h4>
                            <div class="text-muted small">Last updated: <span id="current-time">{{ now()->format('d M Y H:i:s') }}</span></div>
                        </div>
                        <!-- User Stats Cards -->
                        <div class="row">
                            @php
                                $cards = [
                                    ['label' => 'Total Users', 'count' => $totalUsers, 'color' => 'rgb(64, 72, 114)', 'icon' => 'fas fa-users'],
                                    ['label' => 'Admins', 'count' => $adminCount, 'color' => 'rgb(75, 100, 180)', 'icon' => 'fas fa-user-shield'],
                                    ['label' => 'Apotekers', 'count' => $apotekerCount, 'color' => 'rgb(71, 77, 107)', 'icon' => 'fas fa-user-nurse'],
                                    ['label' => 'Employees', 'count' => $karyawanCount, 'color' => 'rgb(85, 90, 130)', 'icon' => 'fas fa-user-tie'],
                                    ['label' => 'Cashiers', 'count' => $kasirCount, 'color' => 'rgb(60, 70, 120)', 'icon' => 'fas fa-cash-register'],
                                    ['label' => 'Owners', 'count' => $pemilikCount, 'color' => 'rgb(45, 50, 100)', 'icon' => 'fa-solid fa-user-secret'],
                                ];
                            @endphp

                            @foreach ($cards as $card)
                            <div class="col-xl-4 col-lg-6 col-sm-6 mb-4">
                                <div class="card hover-scale" style="background-color:{{ $card['color'] }}; border: none; margin-top: 30px;">
                                    <div class="card-body text-white">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-white-20 text-white mr-3">
                                                <i class="{{ $card['icon'] }}"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-0 text-white">{{ $card['count'] }}</h3>
                                                <span>{{ $card['label'] }}</span>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('admin.users.index') }}" class="text-white d-flex align-items-center">
                                                Manage Users <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
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
    setInterval(updateCurrentTime, 1000);
    updateCurrentTime();
</script>
@endsection
@endsection
