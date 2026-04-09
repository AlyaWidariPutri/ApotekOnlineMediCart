<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\JenisObat;
use App\Models\Distributor;
use Illuminate\Http\Request;

class ApotekerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view ('apoteker.index', [
        //     'title' => 'Apoteker'
        // ]);
        date_default_timezone_set('Asia/Jakarta');
        $medicineCount = Obat::count();
        $medicineTypeCount = JenisObat::count();
        $distributorCount = Distributor::count();
        
        $lastMedicine = Obat::latest()->first();
        $lastType = JenisObat::latest()->first();
        $lastDistributor = Distributor::latest()->first();
        
        
        return view('apoteker.index', [
            'title' => 'Apoteker',
            'medicineCount' => $medicineCount,
            'medicineTypeCount' => $medicineTypeCount,
            'distributorCount' => $distributorCount,
            'lastMedicineUpdate' => $lastMedicine ? $lastMedicine->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : 'N/A',
            'lastTypeUpdate' => $lastType ? $lastType->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : 'N/A',
            'lastDistributorUpdate' => $lastDistributor ? $lastDistributor->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : 'N/A',
        ]);
    }

    public function dashboard()
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $medicineCount = Obat::count();
        $medicineTypeCount = JenisObat::count();
        $distributorCount = Distributor::count();
        
        $lastMedicine = Obat::latest()->first();
        $lastType = JenisObat::latest()->first();
        $lastDistributor = Distributor::latest()->first();
        
        
        return view('be.dashboard', [
            'medicineCount' => $medicineCount,
            'medicineTypeCount' => $medicineTypeCount,
            'distributorCount' => $distributorCount,
            'lastMedicineUpdate' => $lastMedicine ? $lastMedicine->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : 'N/A',
            'lastTypeUpdate' => $lastType ? $lastType->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : 'N/A',
            'lastDistributorUpdate' => $lastDistributor ? $lastDistributor->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : 'N/A',
            'currentTime' => now()->setTimezone('Asia/Jakarta')->format('d M Y')
        ]);
    }
    
    /**
     * Format waktu ke timezone lokal (Asia/Jakarta)
     */
    private function formatLocalTime($timestamp, $format = 'd M Y H:i:s')
    {
        return $timestamp->setTimezone('Asia/Jakarta')->format($format);

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
