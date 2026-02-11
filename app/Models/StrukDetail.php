<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukDetail extends Model
{
    use HasFactory;

    protected $table = 'struk_details';

    protected $fillable = [
        'struk_id',
        'produkid',
        'harga_satuan',
        'jumlah',
        'subtotal'
    ];

    public function struk()
    {
        return $this->belongsTo(Struk::class, 'struk_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produkid');
    }
}
