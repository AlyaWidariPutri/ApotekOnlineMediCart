<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        // PERBAIKAN: ambil dari .env, bukan hardcode
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = 'https://api.rajaongkir.com/starter';
    }

    // Mencari kota berdasarkan nama
    public function searchCity(Request $request)
    {
        $cityName = $request->query('city');
        
        if (!$cityName) {
            return response()->json(['success' => false, 'data' => []]);
        }
        
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/city', [
                'search' => $cityName
            ]);
            
            $data = $response->json();
            
            if (isset($data['rajaongkir']['status']['code']) && $data['rajaongkir']['status']['code'] == 200) {
                return response()->json([
                    'success' => true,
                    'data' => $data['rajaongkir']['results']
                ]);
            }
            
            return response()->json(['success' => false, 'data' => [], 'message' => 'Kota tidak ditemukan']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    // Menghitung ongkos kirim
    public function calculateCost(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'weight' => 'required|integer',
            'courier' => 'required'
        ]);
        
        try {
            $response = Http::asForm()->withHeaders([
                'key' => $this->apiKey
            ])->post($this->baseUrl . '/cost', [
                'origin' => $request->origin,
                'destination' => $request->destination,
                'weight' => $request->weight,
                'courier' => $request->courier
            ]);
            
            $data = $response->json();
            
            return response()->json($data);
            
        } catch (\Exception $e) {
            return response()->json([
                'rajaongkir' => [
                    'status' => [
                        'code' => 500,
                        'description' => $e->getMessage()
                    ]
                ]
            ], 500);
        }
    }
    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/province');

        return response()->json($response->json());
    }

    public function getCities(Request $request)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/city', [
            'province' => $request->province
        ]);

        return response()->json($response->json());
    }
}