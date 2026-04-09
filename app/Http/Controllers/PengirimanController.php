<?php
// app/Http/Controllers/PengirimanController.php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengiriman = Pengiriman::with('penjualan.pelanggan')->get();
        
        return view('pengiriman.index', [
            'title' => 'Data Pengiriman',
            'menu' => 'Pengiriman',
            'pengiriman' => $pengiriman
        ]);
    }
    
    /**
     * Show form create pengiriman
     */
    public function create($id_penjualan = null)
    {
        $penjualan = Penjualan::where('status_order', 'Menunggu Kurir')
                              ->with('pelanggan')
                              ->get();
        
        $selectedPenjualan = null;
        if($id_penjualan) {
            $selectedPenjualan = Penjualan::find($id_penjualan);
        }
        
        return view('pengiriman.create', [
            'title' => 'Tambah Pengiriman',
            'menu' => 'Pengiriman',
            'penjualan' => $penjualan,
            'selectedPenjualan' => $selectedPenjualan
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_penjualan' => 'required|exists:penjualan,id',
            'nama_kurir' => 'required|string|max:30',
            'telpon_kurir' => 'required|string|max:15',
            'no_invoice' => 'required|string|max:255',
            'tgl_kirim' => 'required|date',
            'tgl_tiba' => 'nullable|date',
            'keterangan' => 'nullable|string'
        ]);
        
        DB::beginTransaction();
        try {
            $pengiriman = Pengiriman::create([
                'id_penjualan' => $request->id_penjualan,
                'no_invoice' => $request->no_invoice,
                'tgl_kirim' => $request->tgl_kirim,
                'tgl_tiba' => $request->tgl_tiba,
                'status_kirim' => 'Sedang Dikirim',  // Perbaiki: hapus kondisi ternary yang salah
                'nama_kurir' => $request->nama_kurir,
                'telpon_kurir' => $request->telpon_kurir,
                'keterangan' => $request->keterangan
            ]);
            
            // PERBAIKI: Gunakan status yang sudah ada di ENUM
            $penjualan = Penjualan::find($request->id_penjualan);
            $penjualan->status_order = 'Diproses';  // Ganti 'Sedang Dikirim' dengan 'Diproses'
            $penjualan->keterangan_status = 'Pesanan sedang dikirim oleh ' . $request->nama_kurir;
            $penjualan->save();
            
            DB::commit();
            
            return redirect()->route('pengiriman.index')
                        ->with('success', 'Data pengiriman berhasil ditambahkan');
                        
        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Update status pengiriman
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_kirim' => 'required|in:Sedang Dikirim,Tiba di Tujuan',
            'bukti_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ]);
        
        DB::beginTransaction();
        try {
            $pengiriman = Pengiriman::findOrFail($id);
            $pengiriman->status_kirim = $request->status_kirim;
            
            if($request->status_kirim == 'Tiba di Tujuan') {
                $pengiriman->tgl_tiba = now();
                
                // Update status penjualan menjadi selesai
                $penjualan = Penjualan::find($pengiriman->id_penjualan);
                $penjualan->status_order = 'Selesai';  // Pastikan 'Selesai' ada di ENUM
                $penjualan->keterangan_status = 'Pesanan telah sampai di tujuan';
                $penjualan->save();
            }
            
            if($request->hasFile('bukti_foto')) {
                $pengiriman->bukti_foto = $request->file('bukti_foto')->store('bukti_pengiriman', 'public');
            }
            
            $pengiriman->save();
            
            DB::commit();
            
            return back()->with('success', 'Status pengiriman berhasil diupdate');
            
        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengiriman = Pengiriman::with('penjualan.pelanggan', 'penjualan.detail_penjualan.obat')
                                ->findOrFail($id);
        
        return view('pengiriman.show', [
            'title' => 'Detail Pengiriman',
            'menu' => 'Pengiriman',
            'pengiriman' => $pengiriman
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        
        return view('pengiriman.edit', [
            'title' => 'Edit Pengiriman',
            'menu' => 'Pengiriman',
            'pengiriman' => $pengiriman
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kurir' => 'required|string|max:30',
            'telpon_kurir' => 'required|string|max:15',
            'no_invoice' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);
        
        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->update($request->all());
        
        return redirect()->route('pengiriman.index')
                       ->with('success', 'Data pengiriman berhasil diupdate');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->delete();
        
        return redirect()->route('pengiriman.index')
                       ->with('success', 'Data pengiriman berhasil dihapus');
    }
}