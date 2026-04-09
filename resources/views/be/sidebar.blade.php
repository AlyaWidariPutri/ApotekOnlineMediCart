@if(isset($title) && !empty($title))
<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            
            <!-- MENU UNTUK ADMIN SAJA -->
            @if(auth()->user()->jabatan === 'admin')
                
                <!-- Dashboard Admin -->
                <li>
                    <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-universal-access"></i> Dashboard Admin
                    </a>
                </li>

                <!-- Laporan Pembelian -->
                <li>
                    <a href="{{ route('laporan.pembelian') }}" class="{{ request()->is('laporan/pembelian') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i> Laporan Pembelian
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan.penjualan') }}" class="{{ request()->is('laporan/penjualan*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Laporan Penjualan
                    </a>
                </li>
                
                <!-- User Management -->
                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa fa-users"></i> User Management
                    </a>
                </li>
                
                <!-- Data Pelanggan -->
                <li>
                    <a href="{{ route('admin.customers') }}" class="{{ request()->routeIs('admin.customers') || request()->routeIs('admin.customers.show') ? 'active' : '' }}">
                        <i class="fas fa-user-friends"></i> Data Pelanggan
                    </a>
                </li>
            @endif

            <!-- MENU UNTUK PEMILIK -->
            @if(auth()->user()->jabatan === 'pemilik')
                <!-- Dashboard Pemilik -->
                <li>
                    <a href="{{ route('pemilik.index') }}" class="{{ request()->routeIs('pemilik.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-universal-access"></i> Dashboard Pemilik
                    </a>
                </li>
                
                
                <!-- Laporan Pembelian -->
                <li>
                    <a href="{{ route('laporan.pembelian') }}" class="{{ request()->is('laporan/pembelian') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i> Laporan Pembelian
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan.penjualan') }}" class="{{ request()->is('laporan/penjualan*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Laporan Penjualan
                    </a>
                </li>

                <li>
                    <a href="{{ route('pemilik.users') }}" class="{{ request()->routeIs('pemilik.users') ? 'active' : '' }}">
                        <i class="fa fa-users"></i> Data Users
                    </a>
                </li>
            @endif

            <!-- MENU UNTUK APOTEKER -->
            @if(auth()->user()->jabatan === 'apoteker')
                <li>
                    <a href="{{ route('apoteker.index') }}">
                        <i class="fa-solid fa-universal-access"></i> Dashboard Apoteker
                    </a>
                </li>

                <li>
                    <a href="{{ route('penjualan.index') }}" class="{{ request()->is('penjualan*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Approve Penjualan
                    </a>
                </li>
                <li>
                    <a href="{{ route('obat.index') }}" class="@if(@isset($menu) and $menu === 'Obat') active @endif">
                        <i class="fas fa-pills me-2"></i> Medicines
                    </a>
                </li>
                <li>
                    <a href="{{ route('jenis_obat.index') }}" class="@if(@isset($menu) and $menu === 'Jenis Obat') active @endif">
                        <i class="fa-solid fa-prescription-bottle-medical"></i> Type of Medicines
                    </a>
                </li>
                <li>
                    <a href="{{ route('distributor.index') }}">
                        <i class="fas fa-truck me-2"></i> Distributor
                    </a>
                </li>
                <li>
                    <a href="{{ route('apoteker.pembelian.create') }}" class="{{ Request::is('apoteker/pembelian*') ? 'active' : '' }}">
                        <i class="fas fa-cart-plus"></i> Input Pembelian
                    </a>
                </li>
            @endif

            <!-- MENU UNTUK KARYAWAN -->
            @if(auth()->user()->jabatan === 'karyawan')
                <li>
                    <a href="{{ route('karyawan.index') }}">
                        <i class="fa-solid fa-universal-access"></i> Dashboard Karyawan
                    </a>
                </li>
                
                <!-- PENJUALAN (Karyawan - update status ke "Menunggu Kurir") -->
                {{-- <li>
                    <a href="{{ route('karyawan.penjualan.index') }}" class="{{ request()->is('karyawan/penjualan*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Update Status Pesanan
                    </a>
                </li> --}}
                
                <li>
                    <a href="{{ route('obat.index') }}" class="@if(@isset($menu) and $menu === 'Obat') active @endif">
                        <i class="fas fa-pills me-2"></i> Medicines
                    </a>
                </li>
                <li>
                    <a href="{{ route('jenis_obat.index') }}" class="@if(@isset($menu) and $menu === 'Jenis Obat') active @endif">
                        <i class="fa-solid fa-prescription-bottle-medical"></i> Type of Drugs
                    </a>
                </li>
            @endif

            <!-- MENU UNTUK KASIR -->
            @if(auth()->user()->jabatan === 'kasir')
            <!-- PENJUALAN (Kasir) -->
                <li>
                    <a href="{{ route('kasir.index') }}">
                        <i class="fa-solid fa-universal-access"></i> Dashboard Kasir
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengiriman.index') }}" class="{{ request()->routeIs('pengiriman.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-truck"></i> Data Pengiriman
                    </a>
                </li>
                <li>
                    <a href="{{ route('jenis_pengiriman.index') }}">
                        <i class="fa-solid fa-truck-fast"></i> Shipping Method
                    </a>
                </li>
                <li>
                    <a href="{{ route('metode_bayar.index') }}">
                        <i class="fa-solid fa-money-check-dollar"></i> Payment Method
                    </a>
                </li>
                
            @endif

            <!-- LABEL USER & LOGOUT -->
            <li class="nav-label">User</li>

            @if(Auth::check())
                <li>
                    <a href="javascript:void(0);" onclick="document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-to-bracket"></i> Logout
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <li>
                    <a href="{{ route('login') }}">
                        <i class="fa-solid fa-right-to-bracket"></i> Login
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
@endif