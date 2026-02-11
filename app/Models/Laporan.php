<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laporan';
    protected $primaryKey = 'laporanid';
    public $timestamps = true;

    protected $fillable = [
        'userid',
        'pelangganid',
        'tanggal_waktu',
        'tipe',
        'subtotal',
        'diskonRp',
        'poin_use',
        'hargatotal',
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
}
