<?php

namespace App\Http\Controllers;

use App\Models\JenisPengiriman;
use Illuminate\Http\Request;

class JenisPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingMethods = JenisPengiriman::all();
        return view('jenis_pengiriman.index', [
            'title' => 'Kasir',
            'menu' => 'Jenis Pengiriman',
            'shippingMethods' => $shippingMethods
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis_pengiriman.create', [
            'title' => 'Kasir',
            'menu' => 'Jenis Pengiriman'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'jenis_kirim' => 'required|in:ekonomi,kargo,regular,same day,standar',
    //         'nama_ekspedisi' => 'required|string|max:255',
    //         'logo_ekspedisi' => 'required|string|max:255',
    //     ]);

    //     JenisPengiriman::create($request->all());

    //     return redirect()->route('jenis_pengiriman.index')
    //                      ->with('success', 'Shipping method created successfully.');
    // }
    public function store(Request $request)
    {
        $request->validate([
            'kode_kurir' => 'required',
            'layanan' => 'required',
            'jenis_kirim' => 'required',
            'nama_ekspedisi' => 'required',
            'harga' => 'required|numeric',
            'is_active' => 'required',
        ]);

        JenisPengiriman::create([
            'kode_kurir' => strtolower($request->kode_kurir),
            'layanan' => strtoupper($request->layanan),
            'jenis_kirim' => $request->jenis_kirim,
            'nama_ekspedisi' => $request->nama_ekspedisi,
            'harga' => $request->harga,
            'logo_ekspedisi' => $request->logo_ekspedisi,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('jenis_pengiriman.index')
            ->with('success', 'Shipping method berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisPengiriman $jenisPengiriman)
    {
        return view('jenis_pengiriman.show', [
            'title' => 'Kasir',
            'menu' => 'Jenis Pengiriman',
            'jenisPengiriman' => $jenisPengiriman
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPengiriman $jenisPengiriman)
    {
        return view('jenis_pengiriman.edit', [
            'title' => 'Kasir',
            'menu' => 'Jenis Pengiriman',
            'jenisPengiriman' => $jenisPengiriman
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisPengiriman $jenisPengiriman)
    {
        $request->validate([
            'jenis_kirim' => 'required|in:ekonomi,kargo,regular,same day,standar',
            'nama_ekspedisi' => 'required|string|max:255',
            'logo_ekspedisi' => 'required|string|max:255',
        ]);

        $jenisPengiriman->update($request->all());

        return redirect()->route('jenis_pengiriman.index')
                         ->with('success', 'Shipping method updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPengiriman $jenisPengiriman)
    {
        $jenisPengiriman->delete();

        return redirect()->route('jenis_pengiriman.index')
                         ->with('success', 'Shipping method deleted successfully');
    }
}
