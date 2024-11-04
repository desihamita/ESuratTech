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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
                        
            $table->string('nomor_surat')->unique()->comment('Nomor Surat');
            $table->string('no_agenda');
            $table->string('pengirim')->nullable();
            $table->string('penerima')->nullable();
            $table->date('tgl_surat')->nullable();
            $table->date('tgl_diterima')->nullable();
            $table->text('perihal')->nullable();
            $table->text('file_surat')->nullable();
            $table->string('kode_klasifikasi');
            
            $table->foreign('kode_klasifikasi')->references('code')->on('classifications');
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
