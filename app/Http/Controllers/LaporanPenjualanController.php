<?php
// app/Http/Controllers/LaporanPenjualanController.php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPenjualanController extends Controller
{
    /**
     * Display laporan penjualan.
     */
    public function index(Request $request)
    {
        $query = Penjualan::with(['pelanggan', 'metode_bayar', 'detail_penjualan.obat']);
        
        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('tgl_penjualan', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('tgl_penjualan', '<=', $request->end_date);
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_order', $request->status);
        }
        
        $penjualan = $query->orderBy('tgl_penjualan', 'desc')->get();
        
        // Hitung total keseluruhan
        $totalPenjualan = $penjualan->sum('total_bayar');
        $totalPendapatan = $penjualan->where('status_order', 'Selesai')->sum('total_bayar');
        $totalTransaksi = $penjualan->count();
        $totalTransaksiSelesai = $penjualan->where('status_order', 'Selesai')->count();
        
        return view('laporan.penjualan', [
            'title' => 'Laporan Penjualan',
            'penjualan' => $penjualan,
            'totalPenjualan' => $totalPenjualan,
            'totalPendapatan' => $totalPendapatan,
            'totalTransaksi' => $totalTransaksi,
            'totalTransaksiSelesai' => $totalTransaksiSelesai,
            'filters' => $request->all()
        ]);
    }
    
    /**
     * Download PDF Laporan Penjualan
     */
    public function downloadPDF(Request $request)
    {
        $query = Penjualan::with(['pelanggan', 'metode_bayar', 'detail_penjualan.obat']);
        
        if ($request->filled('start_date')) {
            $query->whereDate('tgl_penjualan', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('tgl_penjualan', '<=', $request->end_date);
        }
        
        if ($request->filled('status')) {
            $query->where('status_order', $request->status);
        }
        
        $penjualan = $query->orderBy('tgl_penjualan', 'desc')->get();
        
        $totalPenjualan = $penjualan->sum('total_bayar');
        $totalPendapatan = $penjualan->where('status_order', 'Selesai')->sum('total_bayar');
        $totalTransaksi = $penjualan->count();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.penjualan-pdf', [
            'penjualan' => $penjualan,
            'totalPenjualan' => $totalPenjualan,
            'totalPendapatan' => $totalPendapatan,
            'totalTransaksi' => $totalTransaksi,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status
        ]);
        
        $filename = 'laporan_penjualan_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }
}