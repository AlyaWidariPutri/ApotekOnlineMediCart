<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header" style="display: flex; align-items: center; justify-content: space-between; padding: 0 20px;">
        <div class="brand-logo" style="display: flex; align-items: center; gap: 12px; flex: 1; justify-content: center;">
            <img class="logo-abbr" src="{{ asset('assets/be/images/logo.png') }}" alt="Logo" style="height: 45px; width: auto;">
            <img class="brand-title" src="{{ asset('assets/be/images/logo-text.png') }}" alt="Brand" style="height: 35px; width: auto;">
        </div>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>

    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
        Header start
    ***********************************-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto" style="margin-left: auto !important;">
                        <!-- Profile dropdown di kanan -->
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <i class="mdi mdi-account" style="font-size: 1.3rem;"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if(Auth::check())
                                    <a href="#" class="dropdown-item" style="cursor: default; background: transparent;">
                                        <i class="fa-solid fa-user"></i>
                                        <span class="ml-2">{{ Auth::user()->name }}</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-sign-out-alt"></i>
                                        <span class="ml-2">Logout</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="dropdown-item">
                                        <i class="fa-solid fa-sign-in-alt"></i>
                                        <span class="ml-2">Login</span>
                                    </a>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!--**********************************
        Header end
    ***********************************-->