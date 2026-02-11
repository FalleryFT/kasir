<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('diskon', function (Blueprint $table) {
            $table->id('diskonid');
            $table->foreignId('produkid')->constrained('produk');
            $table->integer('diskon');
            $table->date('berlaku_sampai')->nullable(); // Tambahkan ini
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diskon');
    }
};
