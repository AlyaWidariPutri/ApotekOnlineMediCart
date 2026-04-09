<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Coba login dengan guard 'web' (default untuk user backend)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Get authenticated user
            $user = Auth::user();
            
            // Redirect berdasarkan jabatan
            return $this->redirectBasedOnRole($user);
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Fungsi redirect berdasarkan role/jabatan
    protected function redirectBasedOnRole($user)
    {
        switch($user->jabatan) {
            case 'admin':
                return redirect()->route('admin.index');
            case 'apoteker':
                return redirect()->route('apoteker.index');
            case 'karyawan':
                return redirect()->route('karyawan.index');
            case 'kasir':
                return redirect()->route('kasir.index');
            case 'pemilik':
                return redirect()->route('pemilik.index');
            default:
                return redirect('/home');
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}