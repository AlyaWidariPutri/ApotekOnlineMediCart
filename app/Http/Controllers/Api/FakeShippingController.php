<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisPengiriman;
use Illuminate\Http\Request;

class FakeShippingController extends Controller
{
    public function calculateCost(Request $request)
    {
        $request->validate([
            'destination' => 'required|string',
            'courier' => 'required|string'
        ]);
        
        $destination = strtolower($request->destination);
        $courier = strtolower($request->courier);
        
        // Zona dari Bandung
        $zona = $this->getZonaFromBandung($destination);
        
        // 🔥 AMBIL LAYANAN UNTUK KURIR INI DARI DB
        $shippingMethods = JenisPengiriman::where('kode_kurir', $courier)
            ->where('is_active', true)
            ->get();
        
        // Kalau belum ada data, kasih default
        if ($shippingMethods->isEmpty()) {
            // Fallback data
            $costs = [
                [
                    'service' => 'REG',
                    'description' => 'Reguler',
                    'cost' => [['value' => 10000 + $this->getZonaCost($zona), 'etd' => '2-3 hari']]
                ],
                [
                    'service' => 'YES',
                    'description' => 'Same Day',
                    'cost' => [['value' => 25000 + $this->getZonaCost($zona), 'etd' => '1 hari']]
                ]
            ];
        } else {
            $costs = [];
            foreach ($shippingMethods as $method) {
                $finalPrice = $method->harga + $this->getZonaCost($zona);
                
                $costs[] = [
                    'service' => $method->layanan,
                    'description' => $method->nama_ekspedisi . ' - ' . $method->layanan,
                    'cost' => [
                        [
                            'value' => $finalPrice,
                            'etd' => $this->getEtd($zona, $method->layanan),
                            'note' => ''
                        ]
                    ]
                ];
            }
        }
        
        return response()->json([
            'rajaongkir' => [
                'status' => ['code' => 200, 'description' => 'OK'],
                'results' => [
                    ['name' => strtoupper($courier), 'costs' => $costs]
                ]
            ]
        ]);
    }
    
    private function getZonaFromBandung($cityName)
    {
        $zona1 = ['bandung', 'cimahi', 'sumedang', 'padalarang'];
        $zona2 = ['jakarta', 'depok', 'bekasi', 'tangerang', 'bogor'];
        $zona3 = ['surabaya', 'semarang', 'yogyakarta', 'malang', 'solo'];
        $zona4 = ['medan', 'palembang', 'makassar', 'balikpapan', 'manado', 'padang'];
        
        if (in_array($cityName, $zona1)) return 1;
        if (in_array($cityName, $zona2)) return 2;
        if (in_array($cityName, $zona3)) return 3;
        if (in_array($cityName, $zona4)) return 4;
        
        return 3;
    }
    
    private function getZonaCost($zona)
    {
        $costs = [1 => 0, 2 => 5000, 3 => 15000, 4 => 30000];
        return $costs[$zona] ?? 15000;
    }
    
    private function getEtd($zona, $layanan)
    {
        if (in_array($layanan, ['YES', 'BEST', 'Sameday', 'same day'])) {
            return '1 hari';
        }
        
        $etds = [1 => '1-2 hari', 2 => '2-3 hari', 3 => '3-4 hari', 4 => '4-6 hari'];
        return $etds[$zona] ?? '3-5 hari';
    }
}