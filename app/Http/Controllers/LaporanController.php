<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
{
    $laporanQuery = Laporan::with(['user', 'pelanggan'])->orderBy('created_at', 'desc');

    // Filter berdasarkan tanggal jika ada
    if ($request->has('start_date') && $request->has('end_date')) {
        $laporanQuery->whereBetween('created_at', [
            $request->input('start_date'),
            $request->input('end_date')
        ]);
    }

    $laporan = $laporanQuery->get();

    if ($request->ajax()) {
        return DataTables::of($laporan)->make(true);
    }

    return view('laporan.index', compact('laporan'));
}

    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function show(Request $request)
    {
        $laporanQuery = Laporan::with('user', 'pelanggan')->orderBy('created_at', 'desc');
    
        if ($request->has('start_date') && $request->has('end_date')) {
            $laporanQuery->whereDate('created_at', '>=', $request->input('start_date'))
                ->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $laporan = $laporanQuery->get();
    
        $pdf = PDF::loadView('laporan.pdf', compact('laporan'));
        return $pdf->download('laporan_penjualan.pdf');
    }
    

}
