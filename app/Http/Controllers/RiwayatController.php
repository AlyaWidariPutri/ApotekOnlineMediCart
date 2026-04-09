<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:pelanggan');
    }

    public function index()
    {
        $pesanan = Penjualan::with([
                'detail_penjualan.obat',
                'metode_bayar',
                'jenis_kirim'
            ])
            ->where('id_pelanggan', Auth::guard('pelanggan')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // TAMBAHKAN INI
        $title = 'Riwayat Pesanan';

        return view('fe.riwayat', compact('pesanan', 'title'));
    }

    public function show($id)
    {
        $invoice = Penjualan::with([
                'detail_penjualan.obat',
                'pelanggan',
                'metode_bayar',
                'jenis_kirim'
            ])
            ->where('id_pelanggan', Auth::guard('pelanggan')->id())
            ->findOrFail($id);

        // TAMBAHKAN INI
        $title = 'Invoice #' . $invoice->id;

        return view('fe.invoice', compact('invoice', 'title'));
    }
}