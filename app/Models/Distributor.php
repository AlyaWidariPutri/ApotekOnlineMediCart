<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;
    protected $table = 'distributor'; // Nama tabel di database

    protected $fillable = [
        'nama_distributor',
        'telepon',
        'alamat'
    ];

    // Relasi ke tabel pembelian (One-to-Many)
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_distributor');
    }
}
