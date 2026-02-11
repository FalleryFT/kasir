<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use App\Models\Produk;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DiskonController extends Controller
{
    public function index(Request $request)
{
    $today = now()->toDateString();

    // Ambil semua data diskon dengan produk yang terkait
    $diskon = Diskon::with('produk')->get();

    if ($request->ajax()) {
        return DataTables::of($diskon)
            ->addColumn('status', function ($d) use ($today) {
                return $d->berlaku_sampai < $today
                    ? '<span class="btn btn-secondary">Kedaluwarsa</span>'
                    : '<span class="btn btn-primary">Aktif</span>';
            })
            ->rawColumns(['status']) // Pastikan status bisa dirender sebagai HTML
            ->make(true);
    }

    return view('diskon.index');
}


    public function create()
    {
        $produk = Produk::all();
        return view('diskon.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produkid' => 'required|exists:produk,id',
            'diskon' => 'required|integer|min:0|max:100',
            'berlaku_sampai' => 'nullable|date|after:today' // Tambahkan validasi tanggal
        ]);

        Diskon::create([
            'produkid' => $request->produkid,
            'diskon' => $request->diskon,
            'berlaku_sampai' => $request->berlaku_sampai,
        ]);

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $diskon = Diskon::findOrFail($id);
        $produk = Produk::all();
        return view('diskon.edit', compact('diskon', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'produkid' => 'required|exists:produk,id',
            'diskon' => 'required|integer|min:0|max:100',
            'berlaku_sampai' => 'required|date|after_or_equal:today', // Tambahkan validasi ini
        ]);

        $diskon = Diskon::findOrFail($id);
        $diskon->update([
            'produkid' => $request->produkid,
            'diskon' => $request->diskon,
            'berlaku_sampai' => $request->berlaku_sampai, // Tambahkan ini agar bisa diupdate
        ]);

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $diskon = Diskon::findOrFail($id);
        $diskon->delete();

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil dihapus.');
    }

    public function show($id)
    {
        $diskon = Diskon::with('produk')->findOrFail($id);
        return view('diskon.show', compact('diskon'));
    }
}
