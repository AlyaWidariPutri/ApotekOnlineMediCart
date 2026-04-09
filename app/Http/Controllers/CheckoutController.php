<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Keranjang;
use App\Models\MetodeBayar;
use App\Models\JenisPengiriman;
use App\Models\Obat;
use App\Models\Pengiriman; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:pelanggan');
    }

    public function index()
    {
        $cartItems = Keranjang::with(['obat' => function($query) {
            $query->select('id', 'nama_obat', 'harga_jual', 'idjenis', 'stok', 'berat');
        }, 'obat.jenis'])
        ->where('id_pelanggan', Auth::guard('pelanggan')->id())
        ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        // Cek apakah ada obat Narkotika atau Obat Keras
        $requiresPrescription = $cartItems->contains(function($item) {
            $jenis = $item->obat->jenis->jenis ?? '';
            return in_array($jenis, ['Narkotika', 'Obat Keras']);
        });

        $subtotal = $cartItems->sum('subtotal');
        
        return view('fe.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'metodeBayar' => MetodeBayar::all(),
            'jenisPengiriman' => JenisPengiriman::where('is_active', 1)->get(), // LANGSUNG SEMUA DATA
            'requiresPrescription' => $requiresPrescription,
            'title' => 'Checkout'
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required',
            'alamat_pengiriman' => 'required',
            'no_hp_penerima' => 'required',
            'id_jenis_kirim' => 'required|exists:jenis_pengiriman,id',
            'ongkos_kirim' => 'required|numeric',
            'id_metode_bayar' => 'required|exists:metode_bayar,id',
            'url_resep' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        return DB::transaction(function () use ($request) {
            $cartItems = Keranjang::with('obat')
                        ->where('id_pelanggan', Auth::guard('pelanggan')->id())
                        ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
            }

            // Cek stok
            foreach ($cartItems as $item) {
                if ($item->jumlah_order > $item->obat->stok) {
                    return back()->with('error', 'Stok '.$item->obat->nama_obat.' tidak mencukupi');
                }
            }

            $subtotal = $cartItems->sum('subtotal');
            $ongkir = $request->ongkos_kirim;
            // $biayaApp = 2429;
            $biayaApp = $subtotal * 0.02;  
            $total = $subtotal + $ongkir + $biayaApp;

            // Ambil data jenis pengiriman
            $jenisKirim = JenisPengiriman::findOrFail($request->id_jenis_kirim);

            // Handle file upload resep
            $urlResep = null;
            if ($request->hasFile('url_resep')) {
                $path = $request->file('url_resep')->store('resep', 'public');
                $urlResep = Storage::url($path);
            }

            // Handle file upload bukti transfer
            $buktiTransfer = null;
            if ($request->hasFile('bukti_transfer')) {
                $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
                $buktiTransfer = Storage::url($path);
            }

            // Create main transaction
            $penjualan = Penjualan::create([
                'id_metode_bayar' => $request->id_metode_bayar,
                'tgl_penjualan' => now(),
                'url_resep' => $urlResep,
                'bukti_transfer' => $buktiTransfer,
                'ongkos_kirim' => $ongkir,
                'biaya_app' => $biayaApp,
                'total_bayar' => $total,
                'status_order' => 'Menunggu Konfirmasi',
                'status_pembayaran' => $buktiTransfer ? 'Menunggu Verifikasi' : 'COD',
                'status_resep' => $urlResep ? 'Menunggu Verifikasi' : null,
                'id_jenis_kirim' => $jenisKirim->id,
                'id_pelanggan' => Auth::guard('pelanggan')->id(),
                'nama_penerima' => $request->nama_penerima,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'no_hp_penerima' => $request->no_hp_penerima,
                'keterangan_status' => 'Pesanan baru dibuat'
            ]);

            // Create order details
            foreach ($cartItems as $item) {
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_obat' => $item->id_obat,
                    'jumlah_beli' => $item->jumlah_order,
                    'harga_beli' => $item->obat->harga_jual,
                    'subtotal' => $item->subtotal
                ]);

                // Kurangi stok
                $item->obat->decrement('stok', $item->jumlah_order);
            }

            // Clear cart
            Keranjang::where('id_pelanggan', Auth::guard('pelanggan')->id())->delete();

            return redirect()->route('checkout.summary', $penjualan->id)
                ->with('success', 'Pesanan berhasil! No. Invoice: ' . $penjualan->id);
        });
    }
    // Helper function untuk cek apakah perlu resep
    private function requiresPrescription(Request $request)
    {
        $cartItems = Keranjang::with('obat.jenis')
            ->where('id_pelanggan', Auth::guard('pelanggan')->id())
            ->get();
            
        return $cartItems->contains(function($item) {
            $jenis = $item->obat->jenis->jenis ?? '';
            return in_array($jenis, ['Narkotika', 'Obat Keras']);
        });
    }

    private function mapKurirToJenis($kodeKurir)
    {
        $mapping = [
            'jne' => 'regular',
            'jnt' => 'regular',
            'sicepat' => 'regular',
            'tiki' => 'regular',
            'pos' => 'standar',
        ];
        return $mapping[$kodeKurir] ?? 'regular';
    }

    private function getLogoUrl($kodeKurir)
    {
        $logos = [
            'jne' => '/images/logo/jne.png',
            'jnt' => '/images/logo/jnt.png',
            'sicepat' => '/images/logo/sicepat.png',
            'tiki' => '/images/logo/tiki.png',
            'pos' => '/images/logo/pos.png',
        ];
        return $logos[$kodeKurir] ?? '/images/logo/default.png';
    }

    public function summary($id)
    {
        $invoice = Penjualan::with([
            'detail_penjualan.obat',
            'pelanggan',
            'metode_bayar',
            'jenis_kirim'
        ])->where('id_pelanggan', Auth::guard('pelanggan')->id())
        ->findOrFail($id);

        $pengiriman = Pengiriman::where('id_penjualan', $id)->first();

        // TAMBAHKAN INI - variable title untuk menu active
        $title = 'Checkout Summary';

        return view('fe.checkout-summary', compact('invoice', 'pengiriman', 'title'));
    }
    
}
