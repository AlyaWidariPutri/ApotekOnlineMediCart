<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        // API Key dari file .env (JANGAN HARDCODE)
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        // ENDPOINT BARU yang masih aktif (1 Januari 2025 - sekarang)
        $this->baseUrl = 'https://rajaongkir.komerce.id/api/v1';
    }

    public function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/destination/domestic-destination');

            $data = $response->json();
            
            // Log untuk debugging
            \Log::info('RajaOngkir Provinces Response:', $data);
            
            // Cek apakah response sukses (format response Komerce baru)
            if (isset($data['success']) && $data['success'] === true) {
                // Transform ke format yang dipahami frontend
                $results = [];
                foreach ($data['data'] as $province) {
                    $results[] = [
                        'province_id' => $province['province_id'],
                        'province' => $province['province_name']
                    ];
                }
                
                return response()->json([
                    'rajaongkir' => [
                        'status' => 'ok',
                        'results' => $results
                    ]
                ]);
            } else {
                // Coba endpoint alternatif jika perlu
                return $this->getProvincesAlternate();
            }
            
        } catch (\Exception $e) {
            \Log::error('RajaOngkir Error: ' . $e->getMessage());
            return response()->json([
                'rajaongkir' => [
                    'status' => 'error',
                    'description' => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function getProvincesAlternate()
    {
        try {
            // Endpoint alternatif (tanpa auth)
            $response = Http::get('https://ibnux.github.io/data-indonesia/provinsi.json');
            $data = $response->json();
            
            if ($data && count($data) > 0) {
                $results = [];
                foreach ($data as $province) {
                    $results[] = [
                        'province_id' => $province['id'],
                        'province' => $province['nama']
                    ];
                }
                
                return response()->json([
                    'rajaongkir' => [
                        'status' => 'ok',
                        'results' => $results
                    ]
                ]);
            }
            
            throw new \Exception('Gagal memuat provinsi dari sumber manapun');
            
        } catch (\Exception $e) {
            return response()->json([
                'rajaongkir' => [
                    'status' => 'error',
                    'description' => 'Tidak dapat memuat data provinsi'
                ]
            ], 500);
        }
    }

    public function getCities(Request $request)
    {
        $provinceId = $request->query('province');
        
        if (!$provinceId) {
            return response()->json([
                'rajaongkir' => [
                    'status' => 'error',
                    'description' => 'Province ID diperlukan'
                ]
            ], 400);
        }
        
        try {
            // Coba endpoint Komerce dulu
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/destination/domestic-destination', [
                'province_id' => $provinceId
            ]);

            $data = $response->json();
            \Log::info('RajaOngkir Cities Response:', $data);
            
            if (isset($data['success']) && $data['success'] === true) {
                $results = [];
                foreach ($data['data'] as $city) {
                    $results[] = [
                        'city_id' => $city['city_id'],
                        'city_name' => $city['city_name'],
                        'postal_code' => $city['postal_code'] ?? ''
                    ];
                }
                
                return response()->json([
                    'rajaongkir' => [
                        'status' => 'ok',
                        'results' => $results
                    ]
                ]);
            } else {
                return $this->getCitiesAlternate($provinceId);
            }
            
        } catch (\Exception $e) {
            \Log::error('RajaOngkir Cities Error: ' . $e->getMessage());
            return $this->getCitiesAlternate($provinceId);
        }
    }

    public function getCitiesAlternate($provinceId)
    {
        try {
            // Endpoint alternatif (API publik Indonesia)
            $response = Http::get("https://ibnux.github.io/data-indonesia/kabupaten/{$provinceId}.json");
            $data = $response->json();
            
            if ($data && count($data) > 0) {
                $results = [];
                foreach ($data as $city) {
                    $results[] = [
                        'city_id' => $city['id'],
                        'city_name' => $city['nama'],
                        'postal_code' => ''
                    ];
                }
                
                return response()->json([
                    'rajaongkir' => [
                        'status' => 'ok',
                        'results' => $results
                    ]
                ]);
            }
            
            throw new \Exception('Gagal memuat kota');
            
        } catch (\Exception $e) {
            return response()->json([
                'rajaongkir' => [
                    'status' => 'error',
                    'description' => 'Tidak dapat memuat data kota'
                ]
            ], 500);
        }
    }
    public function searchDestination(Request $request)
    {
        $search = $request->query('search');
        
        if (!$search) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter search diperlukan'
            ], 400);
        }
        
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/destination/domestic-destination', [
                'search' => $search,
                'limit' => 10,
                'offset' => 0
            ]);
            
            $data = $response->json();
            
            if (isset($data['meta']['status']) && $data['meta']['status'] === 'success') {
                // Format response untuk frontend
                $results = [];
                foreach ($data['data'] as $item) {
                    $results[] = [
                        'id' => $item['id'],
                        'label' => $item['label'],
                        'province_name' => $item['province_name'],
                        'city_name' => $item['city_name'],
                        'district_name' => $item['district_name'] ?? '',
                        'subdistrict_name' => $item['subdistrict_name'] ?? '',
                        'zip_code' => $item['zip_code'] ?? ''
                    ];
                }
                
                return response()->json([
                    'success' => true,
                    'data' => $results
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    // Search city by name
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
            
            return response()->json(['success' => false, 'data' => []]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => []]);
        }
    }

    // Calculate shipping cost
    public function getShippingCost(Request $request)
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
            
            return response()->json($response->json());
            
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
}