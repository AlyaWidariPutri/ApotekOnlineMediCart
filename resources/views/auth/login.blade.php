@extends('layouts.auth')

@section('content')
<div class="authincation h-100">
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="auth-form">
                        <h4 class="text-center mb-4">Sign in</h4>

                        <form action="{{ url()->current() }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label><strong>Email</strong></label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}">
                            </div>

                            <div class="form-group">
                                <label><strong>Password</strong></label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" value="{{ old('password') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white">
                                            <i class="fa fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>

                        <div class="new-account mt-3">
                            <p>Contact Admin if you don’t have an account.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}'
            });
        @endif
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    let togglePassword = document.getElementById("togglePassword");
    let passwordField = document.getElementById("password");

    togglePassword.addEventListener("click", function (e) {
        // Cek apakah password dalam bentuk teks atau tidak
        let type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;

        // Ganti ikon sesuai tipe password
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
});

</script>

@endsection
