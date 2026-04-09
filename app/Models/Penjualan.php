<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_metode_bayar',
        'tgl_penjualan',
        'url_resep',
        'ongkos_kirim',
        'biaya_app',
        'total_bayar',
        'status_order',
        'keterangan_status',
        'id_jenis_kirim',
        'id_pelanggan'
    ];

    protected $dates = ['tgl_penjualan'];
    // Relasi ke MetodeBayar
    public function metode_bayar()
    {
        return $this->belongsTo(MetodeBayar::class, 'id_metode_bayar');
    }

    // Relasi ke JenisPengiriman
    public function jenis_kirim()
    {
        return $this->belongsTo(JenisPengiriman::class, 'id_jenis_kirim');
    }

    // Relasi ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi ke DetailPenjualan
    public function detail_penjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'id_penjualan');
    }
    
}