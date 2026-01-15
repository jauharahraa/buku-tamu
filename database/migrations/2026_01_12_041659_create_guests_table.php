<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('guests', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('instansi');
        $table->string('telepon');
        $table->text('keperluan');
        $table->timestamps(); // Ini otomatis menghandle tanggal & waktu
    });
}
};
