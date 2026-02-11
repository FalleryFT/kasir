<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\User;
use App\Models\ItemProduk; // Model barang/produk
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiPenjualanController extends Controller
{
    /**
     * Menampilkan daftar transaksi penjualan.
     */
    public function index()
    {
        $transactions = TransaksiPenjualan::with(['kasir', 'customer'])
            ->latest()
            ->paginate(10);
        return view('transaksi-penjualan.index', compact('transactions'));
    }

    /**
     * Menampilkan form pembuatan transaksi penjualan.
     */
    public function create()
    {
        // Ambil data customer yang memiliki tipe pelanggan
        $customers = User::whereNotNull('tipe_pelanggan')->get();
        // Ambil daftar item produk
        $items = ItemProduk::where('tanggal_kedaluarsa', '>=' , now())->get();
        return view('transaksi-penjualan.create', compact('customers', 'items'));
    }

    /**
     * Menyimpan transaksi penjualan beserta detailnya.
     * Setelah penyimpanan, langsung menampilkan invoice melalui view invoice.blade.php.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'          => 'required|exists:users,id',
            'items'                => 'required|array',
            'items.*.item_id'      => 'required|exists:item_produks,id', // Pastikan nama tabel sesuai
            'items.*.quantity'     => 'required|integer|min:1',
            'amount_paid'          => 'required|numeric|min:0',
        ]);

        // Dapatkan kasir (user yang sedang login) dan customer yang dipilih
        $kasir = Auth::user();
        $customer = User::findOrFail($request->customer_id);

        $subtotal = 0;
        $transactionDetails = [];

        // Looping untuk setiap item yang dibeli
        foreach ($request->items as $trxItem) {
            $item = ItemProduk::findOrFail($trxItem['item_id']);

            // Cek apakah produk sudah kedaluwarsa
            if (!empty($item->tanggal_kedaluarsa) && Carbon::now()->greaterThan(Carbon::parse($item->tanggal_kedaluarsa))) {
                return back()->withErrors([
                    'expired' => 'Produk ' . $item->nama_produk . ' sudah kedaluwarsa dan tidak dapat dijual!'
                ])->withInput();
            }

            // Cek stok yang tersedia
            if ($trxItem['quantity'] > $item->jumlah_stok) {
                return back()->withErrors([
                    'stok' => 'Stok untuk barang ' . $item->nama_produk . ' tidak mencukupi!'
                ])->withInput();
            }

            $quantity = $trxItem['quantity'];

            // Tentukan harga sesuai tipe pelanggan
            if ($customer->tipe_pelanggan == 1) {
                $price = $item->harga_jual_1;
            } elseif ($customer->tipe_pelanggan == 2) {
                $price = $item->harga_jual_2;
            } elseif ($customer->tipe_pelanggan == 3) {
                $price = $item->harga_jual_3;
            } else {
                $price = $item->harga_jual_1;
            }

            $lineSubtotal = $price * $quantity;
            $subtotal += $lineSubtotal;

            $transactionDetails[] = [
                'item_id'    => $item->id,
                'item_name'  => $item->nama_produk,
                'item_price' => $price,
                'quantity'   => $quantity,
                'subtotal'   => $lineSubtotal,
            ];
        }

        // Hitung diskon:
        // - 10% jika subtotal antara 100.000 - 500.000
        // - 20% jika subtotal >= 500.000
        $diskonPercent = 0;
        if ($subtotal >= 100000 && $subtotal < 500000) {
            $diskonPercent = 10;
        } elseif ($subtotal >= 500000) {
            $diskonPercent = 20;
        }
        if ($diskonPercent > 100) {
            $diskonPercent = 100;
        }
        $diskon = ($diskonPercent / 100) * $subtotal;

        // Hitung poin membership yang diperoleh (hanya untuk tipe pelanggan 1 dan 2)
        $membershipPointsEarned = 0;
        if (in_array($customer->tipe_pelanggan, [1, 2])) {
            $membershipPointsEarned = floor(0.02 * $subtotal);
        }

        // Ambil nilai poin yang digunakan
        $pointsUsed = $request->input('membership_points_to_use', 0);
        if ($pointsUsed > $customer->membership_points) {
            $pointsUsed = $customer->membership_points;
        }

        $subtotalAfterDiscount = max($subtotal - $diskon, 0);
        if ($pointsUsed > $subtotalAfterDiscount) {
            $pointsUsed = $subtotalAfterDiscount;
        }
        $subtotalAfterPoints = max($subtotalAfterDiscount - $pointsUsed, 0);

        // Hitung PPN 12%
        $ppn = 0.12 * $subtotalAfterPoints;
        $totalFinal = $subtotalAfterPoints + $ppn;

        $amountPaid = $request->amount_paid;
        if ($amountPaid < $totalFinal) {
            return back()->withErrors([
                'amount_paid' => 'Nominal pembayaran kurang dari total transaksi!'
            ])->withInput();
        }
        $change = $amountPaid - $totalFinal;

        // Simpan data transaksi penjualan, termasuk snapshot nama kasir dan pelanggan
        $transaction = TransaksiPenjualan::create([
            'kasir_id'               => $kasir->id,
            'kasir_nama'             => $kasir->name,       // Snapshot nama kasir
            'customer_id'            => $customer->id,
            'customer_nama'          => $customer->name,    // Snapshot nama pelanggan
            'tipe_pelanggan'         => $customer->tipe_pelanggan,
            'subtotal'               => $subtotal,
            'discount'               => $diskon,
            'membership_points_used' => $pointsUsed,
            'membership_points_earned' => $membershipPointsEarned,
            'ppn'                    => $ppn,
            'total_final'            => $totalFinal,
            'amount_paid'            => $amountPaid,
            'change'                 => $change,
            'transaction_date'       => Carbon::now(),
        ]);

        // Simpan detail transaksi dan perbarui stok barang
        foreach ($transactionDetails as $detail) {
            $item = ItemProduk::find($detail['item_id']);
            $item->jumlah_stok -= $detail['quantity'];
            $item->save();

            $detail['transaction_id'] = $transaction->id;
            DetailTransaksi::create($detail);
        }

        // Update poin membership pelanggan (hanya untuk tipe 1 dan 2)
        if (in_array($customer->tipe_pelanggan, [1, 2])) {
            $customer->membership_points = ($customer->membership_points - $pointsUsed) + $membershipPointsEarned;
            // Jika poin membership mencapai threshold tertentu, ubah tipe pelanggan menjadi 1 (contoh)
            if ($customer->membership_points > 10000) {
                $customer->tipe_pelanggan = 1;
            }
            $customer->save();
        }

        // Setelah transaksi disimpan, langsung render view invoice (invoice.blade.php)
        return view('transaksi-penjualan.invoice', compact('transaction'))
            ->with('success', 'Transaksi berhasil disimpan! Silakan cetak struk.');
    }

    /**
     * Menampilkan detail transaksi sebagai invoice.
     * Jika diperlukan, view invoice.blade.php dapat diakses juga melalui route terpisah.
     */
    public function show($id)
    {
        $transaction = TransaksiPenjualan::with(['details', 'kasir', 'customer'])->findOrFail($id);
        return view('transaksi-penjualan.invoice', compact('transaction'));
    }

    /**
     * Menghapus transaksi penjualan.
     */
    public function destroy($id)
    {
        $transaction = TransaksiPenjualan::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transaksi-penjualan.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}