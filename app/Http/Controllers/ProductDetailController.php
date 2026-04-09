<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    // public function show(string $id)
    // {
    //     return view ('product-detail.show', [
    //         'title' => 'Product Detail'
    //     ]);
    // }
    public function show(string $id)
    {
        $product = \App\Models\Obat::with('jenis')->findOrFail($id);
        
        // Ambil produk terkait (dari kategori yang sama)
        $relatedProducts = \App\Models\Obat::where('idjenis', $product->idjenis)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('fe.product-detail', [
            'title' => $product->nama_obat,
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
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
