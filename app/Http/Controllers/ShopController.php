<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\JenisObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view ('shop.index', [
        //     'title' => 'Product'
        // ]);
        // return view ('shop.index', [
        //     'title' => 'Product', 
        //     'data' => Obat::all() 
        // ]);
        return view('fe.product', [
            'title' => 'Product',
            'data' => Obat::with('jenis')->paginate(6), 
            'categories' => JenisObat::all() 
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
        // $product = Obat::with('jenis')->findOrFail($id);
        
        // return view('fe.product-detail', [
        //     'title' => $product->nama_obat,
        //     'product' => $product
        // ]);

        $product = Obat::with('jenis')->findOrFail($id);
        $relatedProducts = Obat::where('idjenis', $product->idjenis)
                            ->where('id', '!=', $id)
                            ->limit(3)
                            ->get();
                            
        return view('fe.product-detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'title' => $product->nama_obat
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
