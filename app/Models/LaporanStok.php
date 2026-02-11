<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanStok extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laporan_stok';

    protected $fillable = [
        'produk_id',
        'stok_sebelumnya',
        'stok_setelah',
        'tanggal_laporan',
        'created_by',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
