<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Distributor;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelians = Pembelian::with(['distributor', 'details.obat'])
            ->orderBy('tgl_pembelian', 'desc')
            ->get();
            
        return view('apoteker.pembelian.index', compact('pembelians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $distributors = Distributor::all();
        $obats = Obat::all();
        
        return view('apoteker.pembelian.create', compact('distributors', 'obats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log incoming request for debugging
        Log::info('Purchase request data:', $request->all());

        try {
            // Validate the request data
            $validated = $request->validate([
                'id_distributor' => 'required|exists:distributor,id',
                'items' => 'required|array|min:1',
                'items.*.id_obat' => 'required|exists:obat,id',
                'items.*.jumlah' => 'required|integer|min:1',
                'items.*.harga_beli' => 'required|numeric|min:1000'
            ]);

            DB::beginTransaction();

            // Create the purchase record
            $pembelian = Pembelian::create([
                'nonota' => 'PB-'.date('YmdHis'),
                'tgl_pembelian' => now(),
                'id_distributor' => $validated['id_distributor'],
                'total_bayar' => collect($validated['items'])->sum(function($item) {
                    return $item['jumlah'] * $item['harga_beli'];
                })
            ]);

            // Create purchase details and update stock
            foreach ($validated['items'] as $item) {
                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id,
                    'id_obat' => $item['id_obat'],
                    'jumlah_beli' => $item['jumlah'],
                    'harga_beli' => $item['harga_beli'],
                    'subtotal' => $item['jumlah'] * $item['harga_beli']
                ]);

                // Update drug stock
                Obat::where('id', $item['id_obat'])
                    ->increment('stok', $item['jumlah']);
            }

            DB::commit();

            return redirect()->route('apoteker.pembelian.index')
                ->with('success', 'Pembelian berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase error: '.$e->getMessage());
            Log::error($e->getTraceAsString());
            
            return back()->withInput()
                ->with('error', 'Gagal menyimpan: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembelian = Pembelian::with(['distributor', 'details.obat'])
            ->findOrFail($id);
            
        return view('apoteker.pembelian.show', compact('pembelian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pembelian = Pembelian::with(['details'])->findOrFail($id);
        $distributors = Distributor::all();
        $obats = Obat::all();
        
        return view('apoteker.pembelian.edit', compact('pembelian', 'distributors', 'obats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'id_distributor' => 'required|exists:distributor,id',
                'items' => 'required|array|min:1',
                'items.*.id_obat' => 'required|exists:obat,id',
                'items.*.jumlah' => 'required|integer|min:1',
                'items.*.harga_beli' => 'required|numeric|min:1000'
            ]);

            DB::beginTransaction();

            $pembelian = Pembelian::findOrFail($id);
            
            // First, revert the old stock
            foreach ($pembelian->details as $detail) {
                Obat::where('id', $detail->id_obat)
                    ->decrement('stok', $detail->jumlah_beli);
            }
            
            // Delete old details
            $pembelian->details()->delete();

            // Update purchase
            $pembelian->update([
                'id_distributor' => $validated['id_distributor'],
                'total_bayar' => collect($validated['items'])->sum(function($item) {
                    return $item['jumlah'] * $item['harga_beli'];
                })
            ]);

            // Create new details and update stock
            foreach ($validated['items'] as $item) {
                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id,
                    'id_obat' => $item['id_obat'],
                    'jumlah_beli' => $item['jumlah'],
                    'harga_beli' => $item['harga_beli'],
                    'subtotal' => $item['jumlah'] * $item['harga_beli']
                ]);

                Obat::where('id', $item['id_obat'])
                    ->increment('stok', $item['jumlah']);
            }

            DB::commit();

            return redirect()->route('apoteker.pembelian.index')
                ->with('success', 'Pembelian berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase update error: '.$e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Gagal memperbarui: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $pembelian = Pembelian::with('details')->findOrFail($id);
            
            // Revert stock first
            foreach ($pembelian->details as $detail) {
                Obat::where('id', $detail->id_obat)
                    ->decrement('stok', $detail->jumlah_beli);
            }
            
            // Delete the purchase
            $pembelian->delete();

            DB::commit();

            return redirect()->route('apoteker.pembelian.index')
                ->with('success', 'Pembelian berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase deletion error: '.$e->getMessage());
            
            return back()->with('error', 'Gagal menghapus: '.$e->getMessage());
        }
    }

    public function getObatDetail($id)
    {
        $obat = Obat::findOrFail($id);
        return response()->json([
            'stok' => $obat->stok,
            'harga_jual' => $obat->harga_jual
        ]);
    }

    public function exportPdf(Request $request)
    {
        $query = Pembelian::with(['distributor', 'details.obat']);
        
        if ($request->has('periode') && $request->periode) {
            $query->whereYear('tgl_pembelian', substr($request->periode, 0, 4))
                ->whereMonth('tgl_pembelian', substr($request->periode, 5, 2));
        }
        
        $pembelian = $query->orderBy('tgl_pembelian', 'desc')->get();
        
        $pdf = PDF::loadView('apoteker.pembelian.pdf', compact('pembelian'));
        return $pdf->download('laporan_pembelian.pdf');
    }
}