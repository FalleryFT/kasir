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
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $pelanggan = session()->get('member');
        $tipePelanggan = $pelanggan->tipe ?? 'Reguler';

        $totalDiskon = 0;
        $totalBayar = 0;

        // Periksa stok
        foreach ($cart as $produkId => $item) {
            $produk = Produk::find($produkId);
            if (!$produk || $produk->stock < $item['jumlah']) {
                return back()->with('error', "Stok untuk {$item['nama']} tidak mencukupi.");
            }
        }

        // Proses transaksi
        foreach ($cart as $produkId => $item) {
            $produk = Produk::find($produkId);
            $stokSebelumnya = $produk->stock;
            $stokSetelah = $stokSebelumnya - $item['jumlah'];

            $produk->decrement('stock', $item['jumlah']);

            // Simpan laporan stok
            LaporanStok::create([
                'produk_id' => $produkId,
                'stok_sebelumnya' => $stokSebelumnya,
                'stok_setelah' => $stokSetelah,
                'created_by' => Auth::user()->username ?? 'system',
            ]);

            $subtotal = $item['harga_asli'] * $item['jumlah'];
            $diskonRp = ($item['harga_asli'] - $item['harga']) * $item['jumlah']; // Harga sudah termasuk diskon
            $hargaTotal = $item['harga'] * $item['jumlah'];

            $totalDiskon += $diskonRp;
            $totalBayar += $hargaTotal;
        }

        // Hitung Pajak PPN 12%
        $totalPajak = $totalBayar * 0.12;
        $totalAkhir = $totalBayar + $totalPajak; // Total pembayaran sebelum pengurangan poin

        // Ambil jumlah pembayaran dari request
        $jumlahBayar = (int) str_replace('.', '', $request->pembayaran);

        // Hitung kembalian
        $kembalian = $jumlahBayar - $totalAkhir;

        // Pastikan jumlah yang dibayarkan cukup
        if ($jumlahBayar < $totalAkhir) {
            return back()->with('error', 'Jumlah uang yang dibayarkan kurang dari total yang harus dibayar.');
        }

        // Gunakan Poin jika tersedia
        $poinDigunakan = 0;
        if ($pelanggan && $request->poin_use > 0) {
            $poinTersedia = $pelanggan->poin;
            $poinDalamRupiah = $poinTersedia * 1; // 1 poin = Rp 100
            $poinDigunakan = min($poinDalamRupiah, $totalAkhir); // Tidak bisa lebih dari total bayar

            // Kurangi poin pelanggan
            $pelanggan->decrement('poin', floor($poinDigunakan / 1)); // Kurangi sesuai konversi
            $totalAkhir -= $poinDigunakan; // Kurangi total bayar dengan poin
        }

        // Hitung Poin Baru (2% dari total sebelum pajak)
        $poinBaru = floor($totalBayar * 0.02);

        // Simpan ke laporan
        Laporan::create([
            'userid' => Auth::id(),
            'pelangganid' => $pelanggan->id ?? null,
            'tanggal_waktu' => now(),
            'tipe' => $tipePelanggan,
            'subtotal' => $totalBayar + $totalDiskon,
            'diskonRp' => $totalDiskon,
            'pajak' => $totalPajak,
            'poin_use' => $poinDigunakan / 1, // Simpan dalam satuan poin
            'hargatotal' => $totalAkhir, // Total akhir setelah pengurangan poin
            'created_by' => Auth::user()->username,
            'updated_by' => Auth::user()->username,
        ]);

        // Tambahkan Poin Baru ke Pelanggan
        if ($pelanggan) {
            $pelanggan->increment('poin', $poinBaru);
        }

        // Simpan ke struk
        $struk = Struk::create([
            'userid' => Auth::id(),
            'pelangganid' => $pelanggan->id ?? null,
            'produkid' => $produkId,
            'jumlah_produk' => $item['jumlah'],
            'tanggal_penjualan' => now(),
            'subtotal' => $subtotal,
            'diskon' => $diskonRp,
            'pajak' => $totalPajak,
            'total_pembayaran' => $totalAkhir, // Total setelah pajak & diskon
            'jumlah_bayar' => $jumlahBayar, // Jumlah yang dibayarkan customer
            'kembalian' => $kembalian, // Kembalian yang diterima customer
            'poin_digunakan' => $poinDigunakan, // Poin yang digunakan (konversi)
            'poin_didapat' => $poinBaru, // Poin yang diperoleh
            'created_by' => Auth::user()->username,
            'updated_by' => Auth::user()->username,
        ]);
        
        // Simpan rincian struk ke dalam `struk_details`
    foreach ($cart as $produkId => $item) {
        StrukDetail::create([
            'struk_id' => $struk->id,
            'produkid' => $produkId,
            'harga_satuan' => $item['harga_asli'],
            'jumlah' => $item['jumlah'],
            'subtotal' => $item['harga_asli'] * $item['jumlah'],
            'created_by' => Auth::user()->username,
            'updated_by' => Auth::user()->username,
        ]);
    }

        session()->forget(['cart', 'member']);

        return redirect()->route('struk.show', $struk->id);
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