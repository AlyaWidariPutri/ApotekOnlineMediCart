<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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

        $title = 'Riwayat Pesanan';

        return view('fe.riwayat', compact('pesanan', 'title'));  // <-- PERBAIKI INI
    }

    public function downloadPDF($id)
    {
        $invoice = Penjualan::with(['pelanggan', 'detail_penjualan.obat'])->findOrFail($id);
        
        $pdf = PDF::loadView('fe.invoice-pdf', compact('invoice'));
        
        return $pdf->download('invoice-'.$invoice->id.'.pdf');
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
       $invoice = Penjualan::with([
               'detail_penjualan.obat',
               'pelanggan',
               'metode_bayar',
               'jenis_kirim'
           ])
           ->where('id_pelanggan', Auth::guard('pelanggan')->id())
           ->findOrFail($id);

        $title = 'Invoice #' . $invoice->id;

       $title = 'Invoice'; 
       return view('fe.invoice', compact('invoice', 'title'));
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
