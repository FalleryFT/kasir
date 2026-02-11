<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Laporan;
use App\Models\LaporanStok;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPetugas = User::count();
        $totalPelanggan = Pelanggan::count();
        $totalStock = Produk::sum('stock');

        // Menghitung total laporan termasuk LaporanStok
        $totalLaporan = Laporan::count() + LaporanStok::count();

        // Mengambil 5 produk terbaru dengan informasi yang dibutuhkan
        $produkList = Produk::select('kode_produk', 'nama_produk', 'harga_jual', 'stock')
            ->orderBy('stock', 'asc') // Mengurutkan berdasarkan stok paling sedikit
            ->limit(5) // Tetap mengambil 5 produk
            ->get();


        // Data Budget vs Sales
        $budget = 10000000; // Contoh budget
        $sales = Laporan::sum('hargatotal') ?? 0;

        // Ambil data penjualan selama 7 hari terakhir
        $salesData = Laporan::selectRaw('DATE(tanggal_waktu) as date, SUM(hargatotal) as total')
            ->where('tanggal_waktu', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Format data agar sesuai dengan Chart.js
        $weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $weeklySales = array_fill_keys($weekDays, 0);

        foreach ($salesData as $sale) {
            $dayName = Carbon::parse($sale->date)->format('l');
            $weeklySales[$dayName] = $sale->total;
        }

        $labels = array_keys($weeklySales);
        $data = array_values($weeklySales);

        return view('dashboard.index', compact(
            'totalPetugas',
            'totalPelanggan',
            'totalStock',
            'totalLaporan',
            'produkList',
            'budget',
            'sales',
            'labels',
            'data'
        ));
    }
}
