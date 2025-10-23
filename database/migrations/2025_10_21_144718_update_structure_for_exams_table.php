<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// ... (use statements)

public function up(): void
{
    Schema::table('exams', function (Blueprint $table) {

        // --- HAPUS KOLOM LAMA ---
        // GANTI 'link_ujian' DENGAN NAMA KOLOM LINK GFORM ANDA
        if (Schema::hasColumn('exams', 'link_ujian')) {
            $table->dropColumn('link_ujian'); 
        }

        // Hapus kolom lain yang tidak perlu (jika ada)
        // $table->dropColumn('nama_kolom_lain');


        // --- PASTIKAN KOLOM BARU ADA ---
        // Pastikan kolom title ada (mungkin sudah ada)
        if (!Schema::hasColumn('exams', 'title')) {
             $table->string('title')->after('id');
        }

        // Tambahkan kolom deskripsi jika belum ada
        if (!Schema::hasColumn('exams', 'description')) {
             $table->text('description')->nullable()->after('title');
        }
    });
}
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            //
        });
    }
};
