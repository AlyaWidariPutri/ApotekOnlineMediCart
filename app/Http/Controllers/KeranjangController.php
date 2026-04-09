<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:pelanggan')->except(['index']);
    }

    public function index()
    {
        if (!Auth::guard('pelanggan')->check()) {
            return redirect()->route('user.login')->with('error', 'Silakan login terlebih dahulu');
        }

        $keranjang = Keranjang::with('obat')
            ->where('id_pelanggan', Auth::guard('pelanggan')->id())
            ->get();

        return view('fe.cart', [
            'keranjang' => $keranjang,
            'subtotal' => $keranjang->sum('subtotal'),
            'total' => $keranjang->sum('subtotal'),
            'title' => 'Cart'
        ]);
    }

    public function store(Request $request, $id_obat)
    {
        $request->validate([
            'jumlah_order' => 'required|numeric|min:1|max:'.$this->getMaxStock($id_obat)
        ]);

        $obat = Obat::findOrFail($id_obat);
        $user_id = Auth::guard('pelanggan')->id();

        // Cek stok tersedia
        if ($request->jumlah_order > $obat->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia');
        }

        // Cek apakah produk sudah ada di keranjang
        $keranjangItem = Keranjang::where('id_pelanggan', $user_id)
                                ->where('id_obat', $id_obat)
                                ->first();

        if ($keranjangItem) {
            // Jika sudah ada, TAMBAH jumlahnya (bukan ganti)
            $newQuantity = $keranjangItem->jumlah_order + $request->jumlah_order;
            
            // Validasi stok setelah ditambah
            if ($newQuantity > $obat->stok) {
                return back()->with('error', 'Total jumlah melebihi stok tersedia');
            }
            
            $keranjangItem->update([
                'jumlah_order' => $newQuantity,
                'subtotal' => $obat->harga_jual * $newQuantity
            ]);
        } else {
            // Jika belum ada, buat baru
            Keranjang::create([
                'id_pelanggan' => $user_id,
                'id_obat' => $id_obat,
                'jumlah_order' => $request->jumlah_order,
                'harga' => $obat->harga_jual,
                'subtotal' => $obat->harga_jual * $request->jumlah_order
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    private function getMaxStock($id_obat)
    {
        return Obat::findOrFail($id_obat)->stok;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_order' => 'required|numeric|min:1'
        ]);

        $keranjang = Keranjang::findOrFail($id);
        $max_stok = $keranjang->obat->stok;

        if ($request->jumlah_order > $max_stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia. Maksimal ' . $max_stok);
        }

        $keranjang->update([
            'jumlah_order' => $request->jumlah_order,
            'subtotal' => $keranjang->harga * $request->jumlah_order
        ]);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang');
    }
}