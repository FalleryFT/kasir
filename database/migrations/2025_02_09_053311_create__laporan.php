<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('laporanid');
            $table->foreignId('userid')->constrained('users');
            $table->foreignId('pelangganid')->nullable()->constrained('pelanggan');
            $table->dateTime('tanggal_waktu');
            $table->string('tipe');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('diskonRp', 15, 2);
            $table->integer('poin_use')->nullable();
            $table->decimal('hargatotal', 15, 2);
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan');
    }
};
