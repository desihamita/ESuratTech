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
        Schema::create('lembaga', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lembaga', 255);
            $table->string('telepon', 15);
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat', 255)->nullable();
            $table->integer('tahun');
            $table->string('kota', 100);
            $table->string('provinsi', 100);
            $table->string('kepala', 100);
            $table->string('nip', 20);
            $table->string('jabatan', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembaga');
    }
};
