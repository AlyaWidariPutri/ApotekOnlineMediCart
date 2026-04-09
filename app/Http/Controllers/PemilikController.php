<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class PemilikController extends Controller
{
    /**
     * Display dashboard pemilik.
     */
    public function index()
    {
        // Data untuk dashboard
        $totalUsers = User::count();
        $purchaseReportCount = Pembelian::count();
        
        return view('pemilik.index', [
            'title' => 'Dashboard Pemilik',
            'totalUsers' => $totalUsers,
            'purchaseReportCount' => $purchaseReportCount,
        ]);
    }

    /**
     * Display users page.
     */
    public function users()
    {
        $users = User::all();
        
        return view('pemilik.users', [
            'title' => 'Data Users',
            'users' => $users
        ]);
    }
}