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
    Schema::table('schedules', function (Blueprint $table) {
        // Tambahkan kolom baru terlebih dahulu
        $table->dateTime('start_time')->after('category'); // Menyimpan Tanggal & Waktu Mulai
        $table->dateTime('end_time')->after('start_time');   // Menyimpan Tanggal & Waktu Selesai

        // Hapus kolom lama setelah yang baru ditambahkan
        $table->dropColumn(['date', 'time']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
   Schema::table('schedules', function (Blueprint $table) {
        $table->dropColumn(['start_time', 'end_time']);
        $table->date('date');
        $table->string('time');
        });
    }
};
