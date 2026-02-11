<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Struk extends Model
{
    use HasFactory;

    protected $table = 'struk';

    protected $fillable = [
        'userid',
        'pelangganid',
        'produkid',
        'jumlah_produk',
        'tanggal_penjualan',
        'subtotal',
        'diskon',
        'pajak',
        'total_pembayaran',
        'jumlah_bayar',
        'kembalian',
        'poin_digunakan',
        'poin_didapat',
        'created_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelangganid');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produkid');
    }

    public function details()
    {
        return $this->hasMany(StrukDetail::class, 'struk_id');
    }
}
