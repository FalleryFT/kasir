<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Struk;

class StrukController extends Controller
{
    public function show($id)
    {
        $struk = Struk::with('details.produk')->findOrFail($id);

        return view('struk_pdf', compact('struk'));

}

}
