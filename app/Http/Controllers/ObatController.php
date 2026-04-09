<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\JenisObat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('obat.index', [
            'title' => 'Apoteker',
            'menu' => 'Obat',
            'datas' => Obat::with('jenis')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('obat.create', [
            'title' => 'Apoteker',
            'menu' => 'Obat',
            'jenisObats' => JenisObat::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'harga_jual' => str_replace('.', '', $request->harga_jual)
        ]);
        
        $validated = $request->validate([
            'nama_obat' => 'required|max:100',
            'idjenis' => 'required|exists:jenis_obat,id',
            'harga_jual' => 'required|numeric|min:0',
            'deskripsi_obat' => 'required',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stok' => 'required|integer',
            'berat' => 'required|integer|min:1'
        ]);

        try {
            // Upload foto
            for ($i = 1; $i <= 3; $i++) {
                $field = 'foto'.$i;
                if ($request->hasFile($field)) {
                    $validated[$field] = $request->file($field)->store('obat_images', 'public');
                }
            }

            Obat::create($validated);
            return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan obat: '.$e->getMessage());
        }
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
        $obat = Obat::findOrFail($id);
        return view('obat.edit', [
            'title' => 'Apoteker',
            'menu' => 'Obat',
            'data' => $obat,
            'jenisObats' => JenisObat::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge([
            'harga_jual' => str_replace('.', '', $request->harga_jual)
        ]);

        $validated = $request->validate([
            'nama_obat' => 'required|max:100',
            'idjenis' => 'required|exists:jenis_obat,id',
            'harga_jual' => 'required|numeric|min:0',
            'deskripsi_obat' => 'required',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stok' => 'required|integer',
            'berat' => 'required|integer|min:1'
        ]);

        $obat = Obat::findOrFail($id);

        // Handle foto update
        for ($i = 1; $i <= 3; $i++) {
            $field = 'foto'.$i;
            if ($request->hasFile($field)) {
                // Delete old image if exists
                if ($obat->$field) {
                    Storage::disk('public')->delete($obat->$field);
                }
                $validated[$field] = $request->file($field)->store('obat_images', 'public');
            } elseif ($request->has('keep_'.$field) && $request->input('keep_'.$field) == '1') {
                // Keep old image
                $validated[$field] = $obat->$field;
            } else {
                // Remove image if unchecked
                if ($obat->$field) {
                    Storage::disk('public')->delete($obat->$field);
                }
                $validated[$field] = null;
            }
        }

        $obat->update($validated);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        
        // Delete images
        for ($i = 1; $i <= 3; $i++) {
            $field = 'foto'.$i;
            if ($obat->$field) {
                Storage::disk('public')->delete($obat->$field);
            }
        }
        
        $obat->delete();
        
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus');
    }
}