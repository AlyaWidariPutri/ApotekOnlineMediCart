<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pharmacy-dashboard', function() {
    $medicineCount = App\Models\Obat::count();
    $medicineTypeCount = App\Models\JenisObat::count();
    $distributorCount = App\Models\Distributor::count();
    
    $lastMedicine = App\Models\Obat::latest()->first();
    $lastType = App\Models\JenisObat::latest()->first();
    $lastDistributor = App\Models\Distributor::latest()->first();
    
    $recentActivities = [
        [
            'icon' => 'fas fa-pills',
            'title' => 'New Medicine Added',
            'description' => $lastMedicine ? $lastMedicine->nama_obat . ' was added' : 'No recent medicine additions',
            'time' => $lastMedicine ? $lastMedicine->created_at->diffForHumans() : 'N/A'
        ],
        [
            'icon' => 'fas fa-tags',
            'title' => 'New Medicine Type Created',
            'description' => $lastType ? $lastType->nama_jenis . ' was added' : 'No recent type additions',
            'time' => $lastType ? $lastType->created_at->diffForHumans() : 'N/A'
        ],
        [
            'icon' => 'fas fa-truck',
            'title' => 'New Distributor Registered',
            'description' => $lastDistributor ? $lastDistributor->nama_distributor . ' was added' : 'No recent distributor additions',
            'time' => $lastDistributor ? $lastDistributor->created_at->diffForHumans() : 'N/A'
        ]
    ];
    
    return response()->json([
        'medicineCount' => $medicineCount,
        'medicineTypeCount' => $medicineTypeCount,
        'distributorCount' => $distributorCount,
        'lastMedicineUpdate' => $lastMedicine ? $lastMedicine->created_at->format('d M Y H:i') : 'N/A',
        'lastTypeUpdate' => $lastType ? $lastType->created_at->format('d M Y H:i') : 'N/A',
        'lastDistributorUpdate' => $lastDistributor ? $lastDistributor->created_at->format('d M Y H:i') : 'N/A',
        'recentActivities' => $recentActivities
    ]);
});

