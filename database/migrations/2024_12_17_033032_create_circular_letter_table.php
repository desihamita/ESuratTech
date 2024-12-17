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
        Schema::create('circular_letter', function (Blueprint $table) {
            $table->id();
            $table->text('konten');
            $table->unsignedBigInteger('letterout_id');
            
            $table->foreign('letterout_id')->references('id')->on('letters_out')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circular_letter');
    }
};
