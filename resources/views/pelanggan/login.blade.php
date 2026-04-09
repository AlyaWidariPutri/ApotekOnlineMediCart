<div class="auth-container" style="
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #F28132 0%, #FF9F4D 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', sans-serif;
    z-index: 1000;
">
    <div class="auth-box" style="
        background: rgba(255,255,255,0.9);
        border-radius: 20px;
        width: 100%;
        max-width: 400px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        margin: 20px;
    ">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #F28132; font-size: 2.2rem; font-weight: 700; margin-bottom: 5px;">Let's Login! 👋</h1>
            <p style="color: #666;">Sign in to start shopping</p>
        </div>

        <form method="POST" action="{{ route('pelanggan.login.submit') }}">
            @csrf
            <div style="margin-bottom: 20px;">
                <input type="email" name="email" required style="
                    width: 100%;
                    padding: 12px 15px;
                    border: 2px solid #eee;
                    border-radius: 10px;
                    font-size: 1rem;
                    transition: all 0.3s;
                " placeholder="Your Email" value="{{ old('email') }}"
                onfocus="this.style.borderColor='#F28132'"
                onblur="this.style.borderColor='#eee'">
            </div>

            <div style="margin-bottom: 20px; position: relative;">
                <input type="password" name="password" id="password" required style="
                    width: 100%;
                    padding: 12px 15px;
                    border: 2px solid #eee;
                    border-radius: 10px;
                    font-size: 1rem;
                    transition: all 0.3s;
                " placeholder="Password" 
                onfocus="this.style.borderColor='#F28132'"
                onblur="this.style.borderColor='#eee'">
                <i class="fas fa-eye toggle-password" style="
                    position: absolute;
                    right: 15px;
                    top: 50%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    color: #777;
                " onclick="togglePassword()"></i>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="remember" style="margin-right: 8px; accent-color: #F28132;">
                    <span style="color: #555; font-size: 0.9rem;">Remember me</span>
                </label>
                <a href="{{ route('pelanggan.password.request') }}" style="color: #F28132; text-decoration: none; font-size: 0.9rem;">Forgot password?</a>
            </div>

            <button type="submit" style="
                width: 100%;
                padding: 14px;
                background: #F28132;
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
            " onmouseover="this.style.backgroundColor='#e67329'"
            onmouseout="this.style.backgroundColor='#F28132'">
                Login
            </button>
        </form>

        <div style="text-align: center; margin-top: 30px; color: #555;">
            Don't have an account? <a href="{{ route('pelanggan.register') }}" style="color: #F28132; font-weight: 600; text-decoration: none;">Register now</a>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.querySelector('.toggle-password');
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Appear animation
    document.addEventListener('DOMContentLoaded', function() {
        const authBox = document.querySelector('.auth-box');
        authBox.style.opacity = '0';
        authBox.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            authBox.style.transition = 'all 0.5s ease-out';
            authBox.style.opacity = '1';
            authBox.style.transform = 'translateY(0)';
        }, 100);
    });
</script>
