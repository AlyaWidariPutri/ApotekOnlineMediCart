<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    
    protected $fillable = [
        'nonota',
        'tgl_pembelian',
        'id_distributor',
        'total_bayar'
    ];

    // Add this to cast tgl_pembelian as a date
    protected $dates = ['tgl_pembelian'];
    // Or for Laravel 8+:
    protected $casts = [
        'tgl_pembelian' => 'date'
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'id_distributor');
    }

    public function details()
    {
        return $this->hasMany(DetailPembelian::class, 'id_pembelian');
    }
}