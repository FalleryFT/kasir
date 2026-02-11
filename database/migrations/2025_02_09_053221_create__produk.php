<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk');
            $table->string('nama_produk');
            $table->foreignId('kategoriid')->constrained('kategori')->onDelete('cascade');
            $table->decimal('harga_beli', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->integer('stock');
            $table->integer('minimal_stock');
            $table->date('tanggal_pembelian');
            $table->date('tanggal_kadaluarsa')->nullable(); // Menambahkan kolom tanggal kadaluarsa
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
};
