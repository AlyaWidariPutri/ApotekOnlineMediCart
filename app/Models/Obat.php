<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_obat',
        'idjenis',
        'harga_jual',
        'deskripsi_obat',
        'foto1',
        'foto2',
        'foto3',
        'stok',
        'berat'
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisObat::class, 'idjenis');
    }

    // Format tampilan harga
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga_jual, 0, ',', '.');
    }

    // Untuk input harga
    public function setHargaJualAttribute($value)
    {
        $this->attributes['harga_jual'] = str_replace('.', '', $value);
    }
}