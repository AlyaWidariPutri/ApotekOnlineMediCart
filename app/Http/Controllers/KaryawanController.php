<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Obat;
use App\Models\JenisObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $medicineCount = Obat::count();
        $medicineTypeCount = JenisObat::count();
        
        $lastMedicine = Obat::latest()->first();
        $lastType = JenisObat::latest()->first();
        
        return view('karyawan.index', [
            'title' => 'Karyawan',
            'medicineCount' => $medicineCount,
            'medicineTypeCount' => $medicineTypeCount,
            'lastMedicineUpdate' => $lastMedicine ? $lastMedicine->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : 'N/A',
            'lastTypeUpdate' => $lastType ? $lastType->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : 'N/A',
        ]);
    }

    /**
     * Tampilkan daftar pesanan untuk karyawan
     */
    public function penjualan()
    {
        $penjualan = Penjualan::with(['pelanggan'])
                              ->where('status_order', 'Diproses')
                              ->orderBy('tgl_penjualan', 'desc')
                              ->get();
        
        return view('karyawan.penjualan', compact('penjualan'));
    }
    
    /**
     * Update status pesanan ke 'Menunggu Kurir'
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_order' => 'required|in:Menunggu Kurir'
        ]);
        
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::findOrFail($id);
            
            if ($penjualan->status_order != 'Diproses') {
                return back()->with('error', 'Status pesanan harus "Diproses" untuk diupdate');
            }
            
            $penjualan->status_order = $request->status_order;
            $penjualan->keterangan_status = 'Pesanan siap, menunggu kurir mengambil';
            $penjualan->save();
            
            DB::commit();
            
            return redirect()->route('karyawan.penjualan.index')
                           ->with('success', 'Status pesanan berhasil diupdate ke "Menunggu Kurir"');
                           
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    
}