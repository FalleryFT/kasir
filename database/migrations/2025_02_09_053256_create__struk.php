<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('struk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userid')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('pelangganid')->nullable()->constrained('pelanggan')->onDelete('set null');
            $table->foreignId('produkid')->constrained('produk')->onDelete('cascade');
            $table->integer('jumlah_produk');
            $table->dateTime('tanggal_penjualan');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('pajak', 15, 2)->default(0);
            $table->decimal('total_pembayaran', 15, 2);
            $table->decimal('jumlah_bayar', 15, 2);
            $table->decimal('kembalian', 15, 2);
            $table->integer('poin_digunakan')->default(0);
            $table->integer('poin_didapat')->default(0);
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('struk');
    }
};
