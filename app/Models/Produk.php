<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produk';
    protected $fillable = ['kode_produk', 'nama_produk', 'kategoriid', 'harga_beli', 'harga_jual', 'stock', 'minimal_stock', 'tanggal_pembelian', 'tanggal_kadaluarsa'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategoriid', 'id');
    }

    public function diskon()
    {
        return $this->hasOne(Diskon::class, 'produkid')->where('berlaku_sampai', '>=', now());
    }
}
