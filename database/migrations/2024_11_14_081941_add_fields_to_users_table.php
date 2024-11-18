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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('id');
            $table->string('jabatan')->nullable()->after('name');
            $table->string('level')->nullable()->after('jabatan');
            $table->enum('status', ['active', 'inactive'])->default('inactive')->after('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nip', 'nama_lengkap', 'jabatan', 'level', 'status']);
        });
    }
};
