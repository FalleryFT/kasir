<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Logger\ConsoleLogger;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $produk = Produk::with('kategori')->get();

        if ($request->ajax()) {
            return DataTables::of($produk)->make(true);
        }
        return view('produk.index', compact('produk'));
    }

    public function getData()
    {
        $produk = Produk::with('kategori')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'kode_produk' => $item->kode_produk,
                'nama_produk' => $item->nama_produk,
                'kategori' => $item->kategori ? $item->kategori->nama_kategori : '-',
                'harga_jual' => $item->harga_jual,
                'stock' => $item->stock,
                'tanggal_kadaluarsa' => $item->tanggal_kadaluarsa, // Menambahkan tanggal kadaluarsa
                'action' => view('produk._action', compact('item'))->render(),
            ];
        });

        return response()->json(['data' => $produk]);
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produk',
            'nama_produk' => 'required',
            'kategoriid' => 'required',
            'tanggal_pembelian' => 'nullable|date',
            'tanggal_kadaluarsa' => 'nullable|date|after_or_equal:tanggal_pembelian', // Validasi tambahan
            'harga_beli' => 'required|numeric',
            'stock' => 'required|integer',
            'minimal_stock' => 'nullable|integer',
        ]);

        $hargaJual = $request->harga_beli * 1.2;

        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'kategoriid' => $request->kategoriid,
            'tanggal_pembelian' => $request->tanggal_pembelian ?? now(),
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $hargaJual,
            'stock' => $request->stock,
            'minimal_stock' => $request->minimal_stock ?? 0,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        return view('produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produk,kode_produk,' . $id . ',id',
            'nama_produk' => 'required',
            'kategoriid' => 'required',
            'harga_beli' => 'required|numeric',
            'stock' => 'required|integer',
            'tanggal_kadaluarsa' => 'nullable|date|after_or_equal:tanggal_pembelian', // Validasi tambahan
        ]);

        $produk = Produk::findOrFail($id);
        $hargaJual = $request->harga_beli * 1.2;

        // Cek apakah stok berubah
        $stokSebelumnya = $produk->stock;
        $stokSetelah = $request->stock;

        // Update produk
        $produk->update([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'kategoriid' => $request->kategoriid,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $hargaJual,
            'stock' => $stokSetelah,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
        ]);

        // Jika stok berubah, tambahkan laporan stok
        if ($stokSebelumnya != $stokSetelah) {
            \App\Models\LaporanStok::create([
                'produk_id' => $produk->id,
                'stok_sebelumnya' => $stokSebelumnya,
                'stok_setelah' => $stokSetelah,
                'created_by' => auth()->user()->username ?? 'system',
            ]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    public function Stok()
    {
        $produk = Produk::all();
        return view('produk.tambah_stok', compact('produk'));
    }

    public function prosesTambahStok(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'tanggal_pembelian' => 'nullable|date',
            'tanggal_kadaluarsa' => 'nullable|date|after_or_equal:tanggal_pembelian',
            'stok_tambahan' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $stokSebelumnya = $produk->stock;
        $stokSetelah = $stokSebelumnya + $request->stok_tambahan;

        // Update stok produk
        $produk->update([
            'stock' => $stokSetelah,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa ?? $produk->tanggal_kadaluarsa,
        ]);
 
        // Tambahkan laporan stok
        \App\Models\LaporanStok::create([
            'produk_id' => $produk->id,
            'stok_sebelumnya' => $stokSebelumnya,
            'stok_setelah' => $stokSetelah,
            'created_by' => auth()->user()->username ?? 'system',
        ]);

        return redirect()->route('produk.index')->with('success', 'Stok berhasil ditambahkan.');
    }
}
