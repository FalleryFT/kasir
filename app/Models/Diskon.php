<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diskon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diskon';
    protected $primaryKey = 'diskonid';
    public $timestamps = true;

    protected $fillable = [
        'produkid',
        'diskon',
        'berlaku_sampai',
        'created_by',
        'updated_by'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produkid', 'id');
    }
}
