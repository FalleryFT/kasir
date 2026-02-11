<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    KasirController,
    LoginController,
    DiskonController,
    ProdukController,
    LaporanController,
    KategoriController,
    DashboardController,
    PelangganController,
    LaporanStokController,
    StrukController
};

// ------------------- Login & Logout Routes -------------------
Route::get('/', [LoginController::class, 'index'])->name('login');  
Route::post('/login/auth', [LoginController::class, 'auth'])->name('login.auth');  
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// ------------------- Dashboard Route -------------------
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ------------------- Kasir Routes -------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::post('/kasir/add-item', [KasirController::class, 'addItem'])->name('kasir.addItem');
    Route::post('/kasir/set-member', [KasirController::class, 'setMember'])->name('kasir.setMember');
    Route::post('/kasir/updateItem/{id}/{action}', [KasirController::class, 'updateItem'])->name('kasir.updateItem');
    Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
    Route::get('/cetak-struk/{id}', [KasirController::class, 'cetakStruk'])->name('cetak.struk');
});

use App\Http\Middleware\RedirectIfGuest;

Route::middleware([RedirectIfGuest::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


// ------------------- Test & Temporary Routes -------------------
Route::get('/test', fn() => view('test'))->name('test');
Route::get('/kas', fn() => view('kasir'))->name('kas');

// ------------------- Resource Routes (CRUD otomatis) -------------------
Route::resources([
    'produk' => ProdukController::class,
    'kategori' => KategoriController::class,
    'pelanggan' => PelangganController::class,
    'users' => UserController::class,
    'diskon' => DiskonController::class,
    'laporan' => LaporanController::class,
    'laporan_stok' => LaporanStokController::class,
    'login' => LoginController::class,
]);

// ------------------- Data API Routes (DataTables) -------------------
Route::prefix('data')->group(function () {
    Route::get('/produk', [ProdukController::class, 'getData'])->name('produk.data');
    Route::get('/kategori', [KategoriController::class, 'getData'])->name('kategori.data');
    Route::get('/pelanggan', [PelangganController::class, 'getData'])->name('pelanggan.data');
    Route::get('/users', [UserController::class, 'getData'])->name('users.data');
    Route::get('/diskon', [DiskonController::class, 'getData'])->name('diskon.data');
    Route::get('/laporan', [LaporanController::class, 'getData'])->name('laporan.data');
    Route::get('/laporan_stok', [LaporanStokController::class, 'getData'])->name('laporan_stok.data');
});

// ------------------- Export Routes -------------------
Route::get('laporan/export-pdf', [LaporanController::class, 'exportPDF'])->name('laporan_penjualan_export_pdf');
Route::get('laporan_stok/export_pdf', [LaporanStokController::class, 'exportPDF'])->name('laporan_stok.export_pdf');

// ------------------- Produk Routes -------------------
Route::get('/produk-tambah-stok', [ProdukController::class, 'Stok'])->name('produk.tambah');
Route::post('/produk/tambah-stok', [ProdukController::class, 'prosesTambahStok'])->name('produk.proses-tambah-stok');

Route::get('/struk/{id}', [StrukController::class, 'show'])->name('struk.show');