<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisObat extends Model
{
    use HasFactory;

    protected $table = 'jenis_obat'; // Nama tabel di database

    protected $fillable = ['jenis', 'deskripsi_jenis', 'image_url'];

    // Relasi ke tabel obat (One-to-Many)
    public function obat()
    {
        return $this->hasMany(Obat::class, 'idjenis');
    }
}
