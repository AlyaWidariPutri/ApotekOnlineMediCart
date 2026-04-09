<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Pelanggan;
use App\Models\Penjualan;


class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

     public function __construct()
    {
        $this->middleware('auth:pelanggan');
    }

    public function edit()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggan,email,'.$pelanggan->id,
            'no_telp' => 'required|string|max:15',
            'propinsi1' => 'required|string|max:255',
            'kota1' => 'required|string|max:255',
            // 'kodepos1' => 'required|string|max:10',
            'kodepos1' => 'nullable|string|max:10',
            'alamat1' => 'required|string|max:500',
            // Tambahan validasi untuk alamat opsional
            'propinsi2' => 'nullable|string|max:255',
            'kota2' => 'nullable|string|max:255',
            'kodepos2' => 'nullable|string|max:10',
            'alamat2' => 'nullable|string|max:500',
            'propinsi3' => 'nullable|string|max:255',
            'kota3' => 'nullable|string|max:255',
            'kodepos3' => 'nullable|string|max:10',
            'alamat3' => 'nullable|string|max:500',
        ]);

        $pelanggan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'propinsi1' => $request->propinsi1,
            'kota1' => $request->kota1,
            'kodepos1' => $request->kodepos1,
            'alamat1' => $request->alamat1,
            'propinsi2' => $request->propinsi2,
            'kota2' => $request->kota2,
            'kodepos2' => $request->kodepos2,
            'alamat2' => $request->alamat2,
            'propinsi3' => $request->propinsi3,
            'kota3' => $request->kota3,
            'kodepos3' => $request->kodepos3,
            'alamat3' => $request->alamat3,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $pelanggan = Auth::guard('pelanggan')->user();

        // Periksa password saat ini dengan enkripsi yang sama
        $encryptedInput = substr(md5($request->current_password), 0, 15);
        
        if ($pelanggan->katakunci !== $encryptedInput) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        // Enkripsi password baru dengan cara yang sama
        $newEncryptedPassword = substr(md5($request->password), 0, 15);
        
        $pelanggan->update([
            'katakunci' => $newEncryptedPassword
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    public function profile()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        return view('pelanggan.profile', [
            'pelanggan' => $pelanggan,
            'title' => 'Profil Saya'
        ]);
    }

    public function showPasswordForm()
    {
        return view('pelanggan.password', [
            'title' => 'Ubah Password'
        ]);
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth('pelanggan')->user();
        
        // Buat folder jika belum ada
        if (!file_exists(public_path('uploads/profiles'))) {
            mkdir(public_path('uploads/profiles'), 0777, true);
        }

        // Hapus foto lama jika ada
        if ($user->foto && file_exists(public_path($user->foto))) {
            unlink(public_path($user->foto));
        }

        // Simpan file baru
        $imageName = time().'.'.$request->foto->extension();  
        $request->foto->move(public_path('uploads/profiles'), $imageName);

        // Update database dengan path relatif ke public
        $user->foto = 'uploads/profiles/'.$imageName;
        $user->save();

        return back()->with('success', 'Foto berhasil diupload');
    }

    public function updateKtp(Request $request)
    {
        $request->validate([
            'url_ktp' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $user = auth('pelanggan')->user();
        
        try {
            if ($request->hasFile('url_ktp')) {
                // Hapus KTP lama jika ada
                if ($user->url_ktp && Storage::disk('public')->exists($user->url_ktp)) {
                    Storage::disk('public')->delete($user->url_ktp);
                }
                
                // Simpan KTP baru
                $path = $request->file('url_ktp')->store('ktp-documents', 'public');
                $user->url_ktp = $path;
                $user->save();
                
                return back()->with('success', 'Dokumen KTP berhasil diperbarui!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupload KTP: '.$e->getMessage());
        }
        
        return back()->with('error', 'Tidak ada file yang diupload');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_pelanggan');
    }

    // public function orders()
    // {
    //    $orders = Penjualan::where('id_pelanggan', Auth::guard('pelanggan')->id())->get();
    //    $title = 'Riwayat Pesanan'; 
    //    return view('fe.orders', compact('orders', 'title'));
    // }

    public function orders()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
    
        $orders = Penjualan::where('id_pelanggan', $pelanggan->id)
                        ->with(['pengiriman']) 
                        ->orderBy('created_at', 'desc')
                        ->get();
        $title = 'Riwayat Pesanan';
        return view('fe.orders', compact('orders', 'title'));
    }
   

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
