<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MediCart {{ $title ?? 'Default Title' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/be/css/app.css') }}">
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/be/images/l2.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/be/vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/be/vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link href="{{ asset('assets/be/vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/be/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!-- End Preloader -->
    
    
    
        <!-- Content Start -->
        <div class="content">
        @yield('sidebar')
        @yield('navbar')
        @yield('content')
    <!-- Konten Halaman -->
    
   
    

    <!-- Footer -->
    <div class="footer">
        <div class="copyright">
            <p>Copyright © Designed & Developed by <a href="#" target="_blank">Quixkit</a> 2019</p>
            <p>Distributed by <a href="https://themewagon.com/" target="_blank">Themewagon</a></p> 
        </div>
    </div>
    <!-- End Footer -->

    <!-- Scripts -->
    <script src="{{ asset('assets/be/js/app.js') }}"></script>
    <script src="{{ asset('assets/be/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/be/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('assets/be/js/custom.min.js') }}"></script>

    <!-- Vectormap -->
    <script src="{{ asset('assets/be/vendor/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/be/vendor/morris/morris.min.js') }}"></script>

    <script src="{{ asset('assets/be/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/be/vendor/chart.js/Chart.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/be/vendor/gaugeJS/dist/gauge.min.js') }}"></script>

    <!-- Flot-chart -->
    <script src="{{ asset('assets/be/vendor/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/be/vendor/flot/jquery.flot.resize.js') }}"></script>

    <!-- Owl Carousel -->
    <script src="{{ asset('assets/be/vendor/owl-carousel/js/owl.carousel.min.js') }}"></script>

    <!-- Counter Up -->
    <script src="{{ asset('assets/be/vendor/jqvmap/js/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/be/vendor/jqvmap/js/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('assets/be/vendor/jquery.counterup/jquery.counterup.min.js') }}"></script>

    <script src="{{ asset('assets/be/js/dashboard/dashboard-1.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{asset('assets/be/js/main.js')}}"></script>
    
    <!-- Template Alert -->
    
    <!-- Sweet Alert -->
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>

    {{-- Tooltip --}}
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    

</body>
</html>

