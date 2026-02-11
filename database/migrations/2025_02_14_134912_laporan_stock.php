<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('laporan_stok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->integer('stok_sebelumnya');
            $table->integer('stok_setelah');
            $table->timestamp('tanggal_laporan')->useCurrent();
            $table->timestamps();
            $table->string('created_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_stok');
    }
};
