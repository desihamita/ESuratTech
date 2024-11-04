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
        Schema::create('letters_out', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique()->comment('Nomor Surat');
            $table->string('no_agenda');
            $table->string('pengirim')->nullable();
            $table->string('penerima')->nullable();
            $table->text('perihal')->nullable();
            $table->string('devisi')->nullable();
            $table->date('tgl_surat')->nullable();
            $table->text('file_surat')->nullable();
            $table->string('kode_klasifikasi');


            $table->foreign('devisi')->references('nama')->on('division');
            $table->foreign('kode_klasifikasi')->references('code')->on('classifications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters_out');
    }
};
