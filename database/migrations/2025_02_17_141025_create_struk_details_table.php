<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('struk_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('struk_id')->constrained('struk')->onDelete('cascade');
            $table->foreignId('produkid')->constrained('produk')->onDelete('cascade');
            $table->integer('harga_satuan');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('struk_details');
    }
};
