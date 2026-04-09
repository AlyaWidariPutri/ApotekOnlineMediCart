<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $distributors = Distributor::all();
        return view('distributor.index', [
            'title' => 'Apoteker',
            'menu' => 'Data Distributor',
            'distributors' => $distributors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('distributor.create', [
            'title' => 'Apoteker',
            'menu' => 'Tambah Distributor'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_distributor' => 'required|string|max:50',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);

        Distributor::create($request->all());

        return redirect()->route('distributor.index')
                         ->with('success', 'Distributor berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $distributor = Distributor::findOrFail($id);
        return view('distributor.show', [
            'distributor' => $distributor,
            'title' => 'Distributor',
            'menu' => 'Detail Distributor'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $distributor = Distributor::findOrFail($id);
        return view('distributor.edit', [
            'distributor' => $distributor,
            'title' => 'Distributor',
            'menu' => 'Edit Distributor'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_distributor' => 'required|string|max:50',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);

        $distributor = Distributor::findOrFail($id);
        $distributor->update($request->all());

        return redirect()->route('distributor.index')
                         ->with('success', 'Data distributor berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $distributor = Distributor::findOrFail($id);
        $distributor->delete();

        return redirect()->route('distributor.index')
                         ->with('success', 'Distributor berhasil dihapus');
    }
}
