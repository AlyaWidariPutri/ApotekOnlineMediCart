<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = DB::table('penjualan')
        ->join('metode_bayar', 'penjualan.id_metode_bayar', '=', 'metode_bayar.id_metode_bayar')
        ->select('penjualan.id_penjualan', 'penjualan.created_at', 'metode_bayar.nama_metode as metode_bayar', 'penjualan.total_bayar')
        ->get();

        $totalIncome = $transactions->sum('total_bayar');

        return view('be.owner.finance-report', compact('transactions', 'totalIncome'));
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
