<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BiteshipLocationController extends Controller
{
    private $apiKey;
    private $baseUrl = 'https://api.biteship.com/v1';

    public function __construct()
    {
        $this->apiKey = env('BITESHIP_API_KEY');
    }

    /**
     * Get all provinces (from Biteship)
     */
    public function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/maps/areas', [
                'countries' => 'ID',
                'type' => 'province'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $provinces = [];
                
                if (isset($data['areas']) && is_array($data['areas'])) {
                    foreach ($data['areas'] as $area) {
                        $provinces[] = [
                            'province_id' => $area['id'],
                            'province' => $area['name'],
                        ];
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'data' => $provinces
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data provinsi'
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cities by province ID (from Biteship)
     */
    public function getCities(Request $request)
    {
        $request->validate([
            'province_id' => 'required|string'
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/maps/areas', [
                'countries' => 'ID',
                'type' => 'city',
                'parents' => $request->province_id
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $cities = [];
                
                if (isset($data['areas']) && is_array($data['areas'])) {
                    foreach ($data['areas'] as $area) {
                        $cities[] = [
                            'city_id' => $area['id'],
                            'city_name' => $area['name'],
                            'postal_code' => $area['postal_code'] ?? '',
                        ];
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'data' => $cities
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kota'
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search location by keyword
     */
    public function searchLocation(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2'
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/maps/areas', [
                'countries' => 'ID',
                'q' => $request->q
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencari lokasi'
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}