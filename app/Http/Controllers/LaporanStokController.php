<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use PDF;
use App\Models\LaporanStok;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaporanStokController extends Controller
{
    public function index(Request $request)
{
    $laporanStokQuery = LaporanStok::with('produk.kategori')->orderBy('created_at', 'desc');

    if ($request->has('start_date') && $request->has('end_date')) {
        $laporanStokQuery->whereBetween('created_at', [
            $request->input('start_date'),
            $request->input('end_date')
        ]);
    }

    $laporanStok = $laporanStokQuery->get();

    if ($request->ajax()) {
        return DataTables::of($laporanStok)->make(true);
    }

    return view('laporan_stok.index', compact('laporanStok'));
}

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'stok_sebelumnya' => 'required|integer',
            'stok_setelah' => 'required|integer',
            'created_by' => 'nullable|string',
        ]);

        LaporanStok::create([
            'produk_id' => $request->produk_id,
            'stok_sebelumnya' => $request->stok_sebelumnya,
            'stok_setelah' => $request->stok_setelah,
            'created_by' => $request->created_by ?? 'system',
        ]);

        return redirect()->route('laporan_stok.index')->with('success', 'Laporan stok berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $laporan = LaporanStok::findOrFail($id);
        $laporan->delete();
        return redirect()->route('laporan_stok.index')->with('success', 'Laporan stok berhasil dihapus.');
    }
    
public function show(Request $request)
    {
        $laporanStokQuery = LaporanStok::with('produk.kategori')->orderBy('created_at', 'desc');
    
        if ($request->has('start_date') && $request->has('end_date')) {
            $laporanStokQuery->whereDate('created_at', '>=', $request->input('start_date'))
                ->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $laporanStok = $laporanStokQuery->get();
    
        $pdf = PDF::loadView('laporan_stok.pdf', compact('laporanStok'));
        return $pdf->download('laporan_stok.pdf');
    }
}
