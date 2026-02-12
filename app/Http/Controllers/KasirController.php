<?php

namespace App\Http\Controllers;

use App\Models\Struk;
use App\Models\StrukDetail;
use App\Models\Diskon;
use App\Models\Produk;
use App\Models\Laporan;
use App\Models\Pelanggan;
use App\Models\LaporanStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        return view('kasir', ['cart' => session()->get('cart', [])]);
    }

    public function setMember(Request $request)
    {
        $pelanggan = Pelanggan::find($request->id_member);

        if (!$pelanggan) {
            return back()->with('error', 'Member tidak ditemukan.');
        }

        session()->put('member', $pelanggan);
        return back()->with('success', 'Member berhasil ditambahkan. Tipe: ' . $pelanggan->tipe);
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|string'
        ]);

        $produk = Produk::where('kode_produk', $request->id_barang)->first();

        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        // Cek apakah barang sudah kadaluarsa
        if ($produk->tanggal_kadaluarsa && $produk->tanggal_kadaluarsa < now()) {
            return back()->with('error', 'Produk telah kadaluarsa dan tidak dapat ditambahkan.');
        }

        if ($produk->stock <= 0) {
            return back()->with('error', 'Stok barang telah habis.');
        }

        $pelanggan = session()->get('member');
        $tipePelanggan = $pelanggan->tipe ?? 'Reguler'; // Default ke Reguler jika tidak ada pelanggan

        // Menyesuaikan harga berdasarkan tipe pelanggan
        $hargaJual = $produk->harga_jual;
        if ($tipePelanggan === 'Reguler') {
            $hargaJual *= 1.3; // Harga +30%
        } elseif ($tipePelanggan === 'VIP') {
            $hargaJual *= 1.2; // Harga +20%
        } elseif ($tipePelanggan === 'VVIP') {
            $hargaJual *= 1.1; // Harga +10%
        }

        // Terapkan diskon jika ada
        $diskon = $produk->diskon;
        $hargaSetelahDiskon = $diskon ? ($hargaJual - ($hargaJual * $diskon->diskon / 100)) : $hargaJual;

        $cart = session()->get('cart', []);

        if (isset($cart[$produk->id])) {
            $cart[$produk->id]['jumlah']++;
        } else {
            $cart[$produk->id] = [
                'kode_produk' => $produk->kode_produk,
                'nama' => $produk->nama_produk,
                'harga_asli' => $hargaJual,
                'diskon' => $diskon ? $diskon->diskon : 0,
                'harga' => $hargaSetelahDiskon,
                'jumlah' => 1,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function updateItem($id, $action)
    {
        $cart = session()->get('cart', []);
        $produk = Produk::find($id);

        if (!isset($cart[$id])) {
            return back()->with('error', 'Produk tidak ditemukan dalam keranjang.');
        }

        // Validasi stok untuk aksi increment
        if ($action === 'increment') {
            // Pastikan jumlah yang akan ditambahkan tidak melebihi stok
            if ($cart[$id]['jumlah'] >= $produk->stock) {
                return back()->with('error', 'Stok produk tidak cukup untuk ditambah.');
            }
            $cart[$id]['jumlah']++;
        } elseif ($action === 'decrement') {
            // Cek apakah jumlah lebih dari 1 sebelum mengurangi
            if ($cart[$id]['jumlah'] > 1) {
                $cart[$id]['jumlah'] -= 1;
            } else {
                unset($cart[$id]); // Hapus barang jika jumlahnya 0
            }
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }


    public function checkout(Request $request)
{
    DB::beginTransaction();

    try {

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $pelanggan = session()->get('member');
        $tipePelanggan = $pelanggan->tipe ?? 'Reguler';

        $totalDiskon = 0;
        $totalBayar = 0;

        // =========================
        // CEK STOK DULU
        // =========================
        $produks = Produk::whereIn('id', array_keys($cart))->get()->keyBy('id');

        foreach ($cart as $produkId => $item) {

            $produk = $produks[$produkId] ?? null;

            if (!$produk || $produk->stock < $item['jumlah']) {
                return back()->with('error', "Stok untuk {$item['nama']} tidak mencukupi.");
            }
        }

        // =========================
        // PROSES PRODUK & KURANGI STOK
        // =========================
        foreach ($cart as $produkId => $item) {

            $produk = $produks[$produkId];

            $stokSebelumnya = $produk->stock;
            $stokSetelah = $stokSebelumnya - $item['jumlah'];

            $produk->decrement('stock', $item['jumlah']);

            LaporanStok::create([
                'produk_id' => $produkId,
                'stok_sebelumnya' => $stokSebelumnya,
                'stok_setelah' => $stokSetelah,
                'created_by' => Auth::user()->username ?? 'system',
            ]);

            $diskonRp = ($item['harga_asli'] - $item['harga']) * $item['jumlah'];
            $hargaTotal = $item['harga'] * $item['jumlah'];

            $totalDiskon += $diskonRp;
            $totalBayar += $hargaTotal;
        }

        // =========================
        // HITUNG PAJAK
        // =========================
        $totalPajak = $totalBayar * 0.12;
        $totalSebelumPoin = $totalBayar + $totalPajak;

        // =========================
        // GUNAKAN POIN (1 poin = Rp100)
        // =========================
        $poinDigunakanRupiah = 0;
        $poinDipakai = 0;

        if ($pelanggan && $request->poin_use > 0) {

            $poinTersedia = $pelanggan->poin;

            $rupiahDariPoin = $poinTersedia * 100;

            // Batasi maksimal hanya sebesar total transaksi
            $poinDigunakanRupiah = min($rupiahDariPoin, $totalSebelumPoin);

            $poinDipakai = floor($poinDigunakanRupiah / 100);

            $pelanggan->decrement('poin', $poinDipakai);
        }

        // =========================
        // TOTAL AKHIR (TIDAK BOLEH NEGATIF)
        // =========================
        $totalAkhir = max(0, $totalSebelumPoin - $poinDigunakanRupiah);

        // =========================
        // PEMBAYARAN
        // =========================
        $jumlahBayar = (int) str_replace('.', '', $request->pembayaran);

        if ($totalAkhir > 0 && $jumlahBayar < $totalAkhir) {
            return back()->with('error', 'Jumlah uang tidak cukup.');
        }

        if ($totalAkhir == 0) {
            $jumlahBayar = 0;
        }

        $kembalian = $jumlahBayar - $totalAkhir;

        // =========================
        // HITUNG POIN BARU (2% dari total sebelum pajak)
        // =========================
        $poinBaru = floor(($totalBayar * 0.02) / 100);

        // =========================
        // SIMPAN LAPORAN
        // =========================
        $laporan = Laporan::create([
            'userid' => Auth::id(),
            'pelangganid' => $pelanggan->id ?? null,
            'tanggal_waktu' => now(),
            'tipe' => $tipePelanggan,
            'subtotal' => $totalBayar + $totalDiskon,
            'diskonRp' => $totalDiskon,
            'pajak' => $totalPajak,
            'poin_use' => $poinDipakai,
            'hargatotal' => $totalAkhir,
            'created_by' => Auth::user()->username,
            'updated_by' => Auth::user()->username,
        ]);

        // =========================
        // TAMBAH POIN BARU
        // =========================
        if ($pelanggan) {
            $pelanggan->increment('poin', $poinBaru);
        }

        // =========================
        // BUAT STRUK UTAMA
        // =========================
        $struk = Struk::create([
            'userid' => Auth::id(),
            'pelangganid' => $pelanggan->id ?? null,
            'tanggal_penjualan' => now(),
            'subtotal' => $totalBayar + $totalDiskon,
            'diskon' => $totalDiskon,
            'pajak' => $totalPajak,
            'total_pembayaran' => $totalAkhir,
            'jumlah_bayar' => $jumlahBayar,
            'kembalian' => $kembalian,
            'poin_digunakan' => $poinDipakai,
            'poin_didapat' => $poinBaru,
            'created_by' => Auth::user()->username,
            'updated_by' => Auth::user()->username,
        ]);

        // =========================
        // SIMPAN DETAIL STRUK
        // =========================
        foreach ($cart as $produkId => $item) {

            StrukDetail::create([
                'struk_id' => $struk->id,
                'produkid' => $produkId,
                'harga_satuan' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['harga'] * $item['jumlah'],
                'created_by' => Auth::user()->username,
                'updated_by' => Auth::user()->username,
            ]);
        }

        session()->forget(['cart', 'member']);

        DB::commit();

        return redirect()->route('struk.show', $struk->id);

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


    public function logoutkasir(Request $request)
    {
        $user = Auth::user();
        Auth::logout();

        if ($user->role == 'Admin') {
            return view('dashboard.index')->with('success', 'Admin berhasil keluar.');
        }

        return redirect('/login')->with('success', 'Berhasil keluar.');
    }
}