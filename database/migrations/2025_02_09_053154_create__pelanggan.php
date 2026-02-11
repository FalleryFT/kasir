<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id(); // Pastikan ada kolom 'id' sebagai primary key
            $table->string('nama_pelanggan');
            $table->string('tipe');
            $table->text('alamat')->nullable();
            $table->string('notelp');
            $table->integer('poin')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }    

    public function down()
    {
        Schema::dropIfExists('pelanggan');
    }
};
