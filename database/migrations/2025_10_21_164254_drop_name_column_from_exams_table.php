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
        Schema::table('exams', function (Blueprint $table) {
            // Kita cek dulu apakah kolom 'name' masih ada
            if (Schema::hasColumn('exams', 'name')) {
                // Hapus kolom 'name' yang sudah tidak dipakai
                $table->dropColumn('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            // (Opsional) Jika di-rollback, buat kolomnya lagi
            $table->string('name')->nullable();
        });
    }
};