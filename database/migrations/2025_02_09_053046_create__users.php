<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('email')->unique();
        $table->string('password');
        $table->string('username');
        $table->string('role');
        $table->timestamps();
        $table->string('created_by')->nullable();
        $table->string('updated_by')->nullable();
    });
}

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
