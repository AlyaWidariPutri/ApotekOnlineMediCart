
<?php 
if (!request()->is('cart*')) {
    unset($keranjang); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Bootstrap4 Shop Template">

    <!-- title -->
    <title>@yield('title', 'MediCart')</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/fe/img/l2.png') }}">
    
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/fe/css/all.min.css') }}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/fe/bootstrap/css/bootstrap.min.css') }}">
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('assets/fe/css/owl.carousel.css') }}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{ asset('assets/fe/css/magnific-popup.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('assets/fe/css/animate.css') }}">
    <!-- mean menu css -->
    <link rel="stylesheet" href="{{ asset('assets/fe/css/meanmenu.min.css') }}">
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('assets/fe/css/main.css') }}">
    <!-- responsive -->
    <link rel="stylesheet" href="{{ asset('assets/fe/css/responsive.css') }}">

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .top-header-area {
            background-color: #051922; 
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            padding: 15px 0;
        }
        
        body {
            padding-top: 80px;
        }
        
        #sticker.sticky {
            background-color: rgba(5, 25, 34, 0.9); 
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 10px 0;
        }
        
        /* Navbar text styling */
        .main-menu ul li a {
            color: white;
            font-weight: 500;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        
        .main-menu ul li a:hover {
            color: #F28123; /* Orange accent color */
        }
        
        /* Logo styling */
        .site-logo img {
            max-height: 40px;
        }
        
        /* Shopping cart icon */
        .header-icons .shopping-cart {
            color: white;
            font-size: 1.2rem;
            margin-right: 10px;
        }
        
        /* Login/Signup buttons */
        .badge {
            padding: 8px 15px;
            border-radius: 50px;
            margin-left: 10px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        /* Keep your existing styles below */
    </style>
    @stack('styles')
</head>
<body>
    
    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
    
    <!-- Header/Navbar -->
    <div class="top-header-area" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- logo -->
                        <div class="site-logo">
                            <a href="{{ route('home.index') }}">
                                <img src="{{ asset('assets/fe/img/medicartlg.png') }}" alt="MediCart">
                            </a>
                        </div>
                        
                        <!-- menu start -->
                        <nav class="main-menu">
                            <ul>
                                <li @if ($title === 'Home') class="current-list-item" @endif>
                                    <a href="{{ route('home.index') }}">Home</a>
                                </li>
                                <li @if ($title === 'About') class="current-list-item" @endif>
                                    <a href="{{ route('about.index') }}">About</a>
                                </li>
                                <li @if ($title === 'Contact') class="current-list-item" @endif>
                                    <a href="{{ route('contact.index') }}">Contact</a>
                                </li>
                                <li @if ($title === 'Shop' || $title === 'Product') class="current-list-item" @endif>
                                    <a href="{{ route('shop.index') }}">Shop</a>
                                </li>
                                @auth('pelanggan')
                                    <li>
                                        <div class="header-icons" style="display: flex; align-items: center; gap: 15px;">
                                            <!-- Shopping Cart -->
                                            <!-- <a class="shopping-cart" href="{{ route('cart.index') }}" style="color: white; font-size: 1.2rem;">
                                                <i class="fas fa-shopping-cart"></i> -->
                                            </a>
                                            <a class="shopping-cart" href="{{ route('cart.index') }}" style="color: white; font-size: 1.2rem;">
                                                <i class="fas fa-shopping-cart"></i>
                                                @auth('pelanggan')
                                                    @php
                                                        $cartCount = App\Models\Keranjang::where('id_pelanggan', Auth::guard('pelanggan')->id())->count();
                                                    @endphp
                                                    @if($cartCount > 0)
                                                        <span class="badge bg-danger" style="font-size: 0.6rem; position: relative; top: -10px; left: -5px;">
                                                            {{ $cartCount }}
                                                        </span>
                                                    @endif
                                                @endauth
                                            </a>

                                            <a href="{{ route('user.orders') }}" style="color: white; font-size: 1.5rem; text-decoration: none;">
                                                <i class="fas fa-money-bill-transfer"></i>
                                            </a>
                                            
                                            <!-- Profile Section -->
                                            <div class="user-profile-nav" style="display: flex; align-items: center; gap: 10px;">
                                                <a href="{{ route('user.profile') }}" style="display: flex; align-items: center; text-decoration: none; gap: 10px;">
                                                    <div class="profile-image-container" style="width: 36px; height: 36px; border-radius: 50%; overflow: hidden; border: 2px solid #F28123;">
                                                        <img src="{{ Auth::guard('pelanggan')->user()->foto ? asset(Auth::guard('pelanggan')->user()->foto) : asset('images/profile/profile.png') }}" 
                                                            alt="Profile" 
                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                    <span style="color: white; font-weight: 500; font-size: 0.95rem;">
                                                        {{ Auth::guard('pelanggan')->user()->nama_pelanggan }}
                                                    </span>
                                                </a>
                                            </div>
                                            
                                            <!-- Logout Button -->
                                            <form method="POST" action="{{ route('user.logout') }}" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="logout-btn" style="background: none; border: none; color: white; cursor: pointer; font-size: 1.2rem;">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @else
                                    <!-- Tampilan belum login -->
                                    <li>
                                        <div class="header-icons" style="display: flex; align-items: center; gap: 15px;">
                                            <a class="shopping-cart" href="{{ route('cart.index') }}" style="color: white; font-size: 1.2rem;">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                            <a class="badge" href="{{ route('user.login') }}" 
                                               style="background-color: #F28123; color: white;">LogIn
                                            </a>
                                            <a class="badge" href="{{ route('user.register') }}" 
                                               style="background-color: white; color: #F28123;">SignIn
                                            </a>
                                        </div>
                                    </li>
                                @endauth
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end header -->
     
    <!-- Conditional Yields -->
     @if($errors->any())
        <div class="alert alert-danger" style="margin: 20px auto; max-width: 1200px;">
            <ul style="margin-bottom: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    @yield('content')
    @if($title === 'Home')
        @yield('banner')
        @yield('features-list')
        @yield('store') 
        @yield('testi')
        @yield('add')
        @yield('shop-banner')
        @yield('logo')
        @yield('search')
    @elseif($title === "About")
        @yield('about')
    @elseif($title === "Contact")
        @yield('contact')
    @elseif($title === "Product")
        @yield('product')
    @endif
    
    <!-- Footer -->
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box about-widget">
                        <h2 class="widget-title">About us</h2>
                        <p>Bringing you the best in healthcare with trusted medicines and compassionate service.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box get-in-touch">
                        <h2 class="widget-title">Get in Touch</h2>
                        <ul>
                            <li>Jakarta, Indonesia</li>
                            <li>support@medicart.com</li>
                            <li>(021) 1234567</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box subscribe">
                        <h2 class="widget-title">Subscribe</h2>
                        <p>Subscribe to our mailing list to get the latest updates.</p>
                        <form action="index.html">
                            <input type="email" placeholder="Email">
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end footer -->
    
    <!-- Copyright -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <p>Copyrights &copy; 2019 - <a href="https://imransdesign.com/">Imran Hossain</a>, All Rights Reserved.<br>
                        Distributed By - <a href="https://themewagon.com/">Themewagon</a>
                    </p>
                </div>
                <div class="col-lg-6 text-right col-md-12">
                    <div class="social-icons">
                        <ul>
                            <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end copyright -->

    <!-- JavaScript -->
    <script>
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('#sticker').addClass('sticky');
        } else {
            $('#sticker').removeClass('sticky');
        }
    });
    </script>
    <script src="{{ asset('assets/fe/js/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('assets/fe/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/fe/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/fe/js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>