<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;
use Illuminate\Support\Str;

class PelangganAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return view('loginn.index', [
    //         'title' => 'Login' // Add this line
    //     ]);
    // }

    // public function showLoginForm()
    // {
    //     return view('loginn.index', ['title' => 'Login']);
    // }
    public function showLoginForm()
    {
        return view('loginn.index', ['title' => 'Login']);
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'katakunci' => 'required'
        ]);

        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if (!$pelanggan) {
            return back()->with('error', 'Email tidak ditemukan')->onlyInput('email');
        }

        $encryptedInput = substr(md5($request->katakunci), 0, 15);
        
        if ($pelanggan->katakunci === $encryptedInput) {
            Auth::guard('pelanggan')->login($pelanggan, $request->has('remember')); // Tambahkan remember
            $request->session()->regenerate();
            return redirect('/')->with('login_success', 'Login berhasil!');
        }

        return back()->with('error', 'Password salah')->onlyInput('email');
    }
    
    public function showRegisterForm()
    {
        return view('loginn.register', ['title' => 'Register']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggan,email',
            'password' => 'required|string|min:4|max:8|confirmed',
        ]);
    
        // Enkripsi yang lebih sederhana untuk memastikan panjang 15 karakter
        $encryptedPassword = substr(md5($request->password), 0, 15);
    
        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $request->name,
            'email' => $request->email,
            'katakunci' => $encryptedPassword,
            'no_telp' => '',
            'alamat1' => '',
            'kota1' => '',
            'propinsi1' => '',
            'kodepos1' => '',
        ]);
    
        Auth::guard('pelanggan')->login($pelanggan);
    
        return redirect()->route('user.login')->with('success', 'Registration successful! Please login');
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
