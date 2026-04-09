<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view ('admin.index', [
        //     'title' => 'Admin'
        // ]);
        // return view('admin.index', [
        //     'title' => 'Admin Dashboard'
        // ]);
        $users = User::all();
        $totalUsers = $users->count();
        $adminCount = $users->where('jabatan', 'admin')->count();
        $apotekerCount = $users->where('jabatan', 'apoteker')->count();
        $karyawanCount = $users->where('jabatan', 'karyawan')->count();
        $kasirCount = $users->where('jabatan', 'kasir')->count();
        $pemilikCount = $users->where('jabatan', 'pemilik')->count();
        return view('admin.index', [
            'title' => 'Admin Dashboard',
            'users' => $users,
            'totalUsers' => $totalUsers,
            'adminCount' => $adminCount,
            'apotekerCount' => $apotekerCount,
            'karyawanCount' => $karyawanCount,
            'kasirCount' => $kasirCount,
            'pemilikCount' => $pemilikCount,
        ]);
    }

    public function customers()
    {
        $pelanggans = \App\Models\Pelanggan::all();
        $totalCustomers = $pelanggans->count();
        
        return view('admin.cust.cust', [
            'title' => 'Admin Dashboard',
            'pelanggans' => $pelanggans,
            'totalCustomers' => $totalCustomers,
        ]);
    }

    public function showCustomer($id)
    {
        $pelanggan = \App\Models\Pelanggan::findOrFail($id);
        
        return view('admin.cust.cust-detail', [
            'title' => 'Detail Pelanggan',
            'pelanggan' => $pelanggan,
        ]);
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
