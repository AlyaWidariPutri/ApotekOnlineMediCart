<?php

namespace App\Http\Controllers;

use App\Models\MetodeBayar;
use App\Models\JenisPengiriman;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view ('kasir.index', [
        //     'title' => 'Kasir'
        // ]);
        date_default_timezone_set('Asia/Jakarta');
        
        // Get counts
        $shippingMethodCount = JenisPengiriman::count();
        $paymentMethodCount = MetodeBayar::count();
        
        // Get latest records
        $lastShippingMethod = JenisPengiriman::latest()->first();
        $lastPaymentMethod = MetodeBayar::latest()->first();
        
        return view('kasir.index', [
            'title' => 'Kasir',
            'shippingMethodCount' => $shippingMethodCount,
            'paymentMethodCount' => $paymentMethodCount,
            'lastShippingMethodUpdate' => ($lastShippingMethod && $lastShippingMethod->created_at) ? $lastShippingMethod->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : 'Belum ada data',            'lastPaymentMethodUpdate' => $lastPaymentMethod ? $lastPaymentMethod->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : 'N/A',
        ]);
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
        //
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
