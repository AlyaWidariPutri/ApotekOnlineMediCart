<?php

namespace App\Http\Controllers;

use App\Models\JenisObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JenisObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $jenisObats = JenisObat::all();
        // return view('jenis_obat.index', compact('jenisObats'));
        $jenisObats = JenisObat::all();
        return view('jenis_obat.index', [
        'jenisObats' => $jenisObats,
        'title' => 'Apoteker', 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis_obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|max:50',
            'deskripsi_jenis' => 'required|max:255',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Simpan gambar ke storage
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('public/jenis_obat_images');
            $validated['image_url'] = str_replace('public/', '', $path); // Simpan path tanpa 'public/'
        }

        JenisObat::create($validated);
        
        return redirect()->route('jenis_obat.index')->with('success', 'Jenis obat berhasil ditambahkan');
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
        $jenisObat = JenisObat::findOrFail($id);
        return view('jenis_obat.edit', compact('jenisObat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jenisObat = JenisObat::findOrFail($id);
        
        $validated = $request->validate([
            'jenis' => 'required|max:50',
            'deskripsi_jenis' => 'required|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('jenis_obat_images', 'public');
            $validated['image_url'] = $path; // Simpan path relatif
        }
        if ($request->hasFile('image_url')) {
            // Delete old image if exists
            if ($jenisObat->image_url && Storage::disk('public')->exists($jenisObat->image_url)) {
                Storage::disk('public')->delete($jenisObat->image_url);
            }
            $validated['image_url'] = $request->file('image_url')->store('jenis_obat_images', 'public');
        } elseif ($request->has('old_image') && $request->old_image == '1') {
            // Keep old image
            $validated['image_url'] = $jenisObat->image_url;
        } else {
            // Delete image if unchecked
            if ($jenisObat->image_url && Storage::disk('public')->exists($jenisObat->image_url)) {
                Storage::disk('public')->delete($jenisObat->image_url);
            }
            $validated['image_url'] = null;
        }

        $jenisObat->update($validated);

        return redirect()->route('jenis_obat.index')->with('success', 'Jenis obat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenisObat = JenisObat::findOrFail($id);
        
        // Delete associated image
        if ($jenisObat->image_url && Storage::disk('public')->exists($jenisObat->image_url)) {
            Storage::disk('public')->delete($jenisObat->image_url);
        }
        
        $jenisObat->delete();
        
        return redirect()->route('jenis_obat.index')->with('success', 'Jenis obat berhasil dihapus');
    }
}


