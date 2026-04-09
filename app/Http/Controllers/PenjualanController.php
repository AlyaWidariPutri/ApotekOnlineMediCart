<?php
// app/Http/Controllers/PenjualanController.php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Obat;
use App\Models\MetodeBayar;
use App\Models\JenisPengiriman;
use App\Models\Pengiriman;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualan = Penjualan::with(['pelanggan', 'metode_bayar', 'jenis_kirim', 'detail_penjualan.obat'])->get();
        
        // Untuk kasir
        if(Auth::user()->role == 'kasir') {
            $penjualan = Penjualan::where('status_order', 'Menunggu Konfirmasi')
                                ->with(['pelanggan', 'metode_bayar', 'jenis_kirim', 'detail_penjualan.obat'])
                                ->get();
        }
        
        return view('penjualan.index', [
            'title' => 'Data Penjualan',
            'menu' => 'Penjualan',
            'penjualan' => $penjualan
        ]);
    }

    /**
     * Checkout dari keranjang
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'id_metode_bayar' => 'required|exists:metode_bayar,id',
            'id_jenis_kirim' => 'required|exists:jenis_pengiriman,id',
            'ongkos_kirim' => 'required|numeric',
            'url_resep' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $pelanggan = Auth::guard('pelanggan')->user();
            $cartItems = Cart::where('id_pelanggan', $pelanggan->id)->with('obat')->get();
            
            if($cartItems->isEmpty()) {
                return back()->with('error', 'Keranjang belanja kosong');
            }
            
            // Cek stok
            foreach($cartItems as $item) {
                if($item->obat->stok < $item->jumlah_order) {
                    return back()->with('error', "Stok {$item->obat->nama_obat} tidak mencukupi");
                }
            }
            
            // Upload resep jika ada
            $urlResep = null;
            if($request->hasFile('url_resep')) {
                $urlResep = $request->file('url_resep')->store('resep', 'public');
            }
            
            // Hitung total
            $subtotal = $cartItems->sum(function($item) {
                return $item->obat->harga_jual * $item->jumlah_order;
            });
            
            $biayaApp = $subtotal * 0.02; // 2% biaya app
            $totalBayar = $subtotal + $request->ongkos_kirim + $biayaApp;
            
            // Buat penjualan
            $penjualan = Penjualan::create([
                'id_metode_bayar' => $request->id_metode_bayar,
                'tgl_penjualan' => now(),
                'url_resep' => $urlResep,
                'ongkos_kirim' => $request->ongkos_kirim,
                'biaya_app' => $biayaApp,
                'total_bayar' => $totalBayar,
                'status_order' => 'Menunggu Konfirmasi',
                'keterangan_status' => 'Menunggu konfirmasi kasir',
                'id_jenis_kirim' => $request->id_jenis_kirim,
                'id_pelanggan' => $pelanggan->id
            ]);
            
            // Buat detail penjualan dan kurangi stok
            foreach($cartItems as $item) {
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_obat' => $item->id_obat,
                    'jumlah' => $item->jumlah_order,
                    'harga_jual' => $item->obat->harga_jual,
                    'subtotal' => $item->obat->harga_jual * $item->jumlah_order
                ]);
                
                // Kurangi stok
                $obat = Obat::find($item->id_obat);
                $obat->stok -= $item->jumlah_order;
                $obat->save();
            }
            
            // Hapus keranjang
            Cart::where('id_pelanggan', $pelanggan->id)->delete();
            
            DB::commit();
            
            return redirect()->route('penjualan.invoice', $penjualan->id)
                           ->with('success', 'Checkout berhasil!');
            
        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Approve penjualan (untuk kasir)
     */
    public function approve($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        
        if($penjualan->status_order != 'Menunggu Konfirmasi') {
            return back()->with('error', 'Penjualan sudah diproses');
        }
        
        $penjualan->status_order = 'Diproses';
        $penjualan->keterangan_status = 'Pesanan sedang dikirim oleh ' . $request->nama_kurir;
        $penjualan->save();
        
        return back()->with('success', 'Penjualan berhasil disetujui');
    }
    
    /**
     * Batalkan penjualan (untuk kasir)
     */
    public function cancel($id)
    {
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::findOrFail($id);
            
            if($penjualan->status_order != 'Menunggu Konfirmasi') {
                return back()->with('error', 'Penjualan tidak dapat dibatalkan');
            }
            
            // Kembalikan stok
            foreach($penjualan->detail_penjualan as $detail) {
                $obat = Obat::find($detail->id_obat);
                $obat->stok += $detail->jumlah;
                $obat->save();
            }
            
            $penjualan->status_order = 'Dibatalkan Penjual';
            $penjualan->keterangan_status = 'Pesanan dibatalkan oleh kasir';
            $penjualan->save();
            
            DB::commit();
            
            return back()->with('success', 'Penjualan dibatalkan');
            
        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan');
        }
    }
    
    /**
     * Update status order (untuk karyawan - menunggu kurir)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_order' => 'required|in:Diproses,Menunggu Kurir,Selesai,Bermasalah'
        ]);
        
        $penjualan = Penjualan::findOrFail($id);
        $oldStatus = $penjualan->status_order;
        $penjualan->status_order = $request->status_order;
        
        switch($request->status_order) {
            case 'Menunggu Kurir':
                $penjualan->keterangan_status = 'Pesanan siap, menunggu kurir mengambil';
                break;
            case 'Selesai':
                $penjualan->keterangan_status = 'Pesanan selesai';
                break;
            case 'Bermasalah':
                $penjualan->keterangan_status = $request->keterangan ?? 'Pesanan bermasalah';
                break;
            default:
                $penjualan->keterangan_status = 'Pesanan sedang diproses';
        }
        
        $penjualan->save();
        
        return back()->with('success', 'Status order berhasil diupdate');
    }
    
    /**
     * Show invoice
     */
    public function invoice($id)
    {
        $penjualan = Penjualan::with(['pelanggan', 'metode_bayar', 'jenis_kirim', 'detail_penjualan.obat'])
                              ->findOrFail($id);
        
        return view('penjualan.invoice', [
            'title' => 'Invoice',
            'menu' => 'Penjualan',
            'penjualan' => $penjualan
        ]);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penjualan = Penjualan::with(['pelanggan', 'metode_bayar', 'jenis_kirim', 'detail_penjualan.obat', 'pengiriman'])
                              ->findOrFail($id);
        
        return view('penjualan.show', [
            'title' => 'Detail Penjualan',
            'menu' => 'Penjualan',
            'penjualan' => $penjualan
        ]);
    }
    
    /**
     * Update verifikasi bayar (untuk admin/kasir)
     */
    public function verifikasiBayar($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->keterangan_status = 'Pembayaran telah diverifikasi';
        $penjualan->save();
        
        return back()->with('success', 'Pembayaran berhasil diverifikasi');
    }
}