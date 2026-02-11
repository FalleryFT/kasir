<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Struk;

class StrukController extends Controller
{
    public function show($id)
{
    $struk = Struk::with('details.produk')->findOrFail($id);

    // Ambil daftar item berdasarkan produk yang dibeli
    $items = [
        [
            'nama' => $struk->produk->nama,
            'harga' => $struk->produk->harga,
            'jumlah' => $struk->jumlah_produk,
            'subtotal' => $struk->subtotal,
            'diskon' => $struk->diskon,
        ]
    ];

    return view('struk_pdf', compact('struk'));
}

}
