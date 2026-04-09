<?php

namespace App\Http\Controllers;

use App\Models\MetodeBayar;
use Illuminate\Http\Request;

class MetodeBayarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = MetodeBayar::all();
        return view('metode_bayar.index', [
            'title' => 'Kasir',
            'menu' => 'Metode Bayar',
            'paymentMethods' => $paymentMethods
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('metode_bayar.create', [
            'title' => 'Kasir',
            'menu' => 'Payment Method'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string|max:30',
            'tempat_bayar' => 'required|string|max:50',
            'no_rekening' => 'nullable|string|max:25',
            'url_logo' => 'nullable|string|max:255',
        ]);

        MetodeBayar::create($request->all());

        return redirect()->route('metode_bayar.index')
                         ->with('success', 'Payment method created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $metodeBayar = MetodeBayar::findOrFail($id);
        return view('metode_bayar.show', [
            'metodeBayar' => $metodeBayar,
            'title' => 'Kasir',
            'menu' => 'Payment Method'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $metodeBayar = MetodeBayar::findOrFail($id);
        return view('metode_bayar.edit', [
            'metodeBayar' => $metodeBayar,
            'title' => 'Kasir',
            'menu' => 'Payment Method'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string|max:30',
            'tempat_bayar' => 'required|string|max:50',
            'no_rekening' => 'nullable|string|max:25',
            'url_logo' => 'nullable|string|max:255',
        ]);

        $metodeBayar = MetodeBayar::findOrFail($id);
        $metodeBayar->update($request->all());

        return redirect()->route('metode_bayar.index')
                         ->with('success', 'Payment method updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $metodeBayar = MetodeBayar::findOrFail($id);
        $metodeBayar->delete();

        return redirect()->route('metode_bayar.index')
                         ->with('success', 'Payment method deleted successfully');
    }
}