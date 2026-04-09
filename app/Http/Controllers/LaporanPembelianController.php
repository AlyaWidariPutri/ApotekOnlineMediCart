<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil periode dari request (format: Y-m)
        $periode = $request->get('periode', date('Y-m'));
        $bulan = date('m', strtotime($periode . '-01'));
        $tahun = date('Y', strtotime($periode . '-01'));

        // Ambil data pembelian dengan relasi lengkap
        $pembelian = Pembelian::with(['distributor', 'details.obat'])
            ->whereYear('tgl_pembelian', $tahun)
            ->whereMonth('tgl_pembelian', $bulan)
            ->orderBy('tgl_pembelian', 'desc')
            ->get();

        return view('admin.laporan.pembelian', [
            'title' => 'Laporan Pembelian',
            'menu' => 'Laporan',
            'pembelian' => $pembelian,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    /**
     * Download PDF Laporan Pembelian
     */
    public function downloadPDF(Request $request)
    {
        // Ambil periode dari request
        $periode = $request->get('periode', date('Y-m'));
        $bulan = date('m', strtotime($periode . '-01'));
        $tahun = date('Y', strtotime($periode . '-01'));

        // Ambil data pembelian dengan relasi lengkap
        $pembelian = Pembelian::with(['distributor', 'details.obat'])
            ->whereYear('tgl_pembelian', $tahun)
            ->whereMonth('tgl_pembelian', $bulan)
            ->orderBy('tgl_pembelian', 'desc')
            ->get();

        // Nama bulan dalam bahasa Indonesia
        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->isoFormat('MMMM');
        
        // Generate PDF
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pembelian', 'bulan', 'tahun', 'namaBulan'));
        
        // Download file
        return $pdf->download('laporan-pembelian-' . $tahun . '-' . $bulan . '.pdf');
    }
}