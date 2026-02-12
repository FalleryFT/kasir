<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('struk', function (Blueprint $table) {

            // Drop foreign key dulu
            $table->dropForeign(['produkid']);

            // Baru drop column
            $table->dropColumn('produkid');

            // Kalau ada
            if (Schema::hasColumn('struk', 'jumlah_produk')) {
                $table->dropColumn('jumlah_produk');
            }
        });
    }

    public function down()
    {
        Schema::table('struk', function (Blueprint $table) {

            $table->unsignedBigInteger('produkid')->nullable();
            $table->integer('jumlah_produk')->nullable();

            $table->foreign('produkid')->references('id')->on('produks');
        });
    }
};
