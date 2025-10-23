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
    Schema::table('exam_results', function (Blueprint $table) {

        // Anda bisa hapus kolom-kolom lama yang tidak terpakai di sini
        // if (Schema::hasColumn('exam_results', 'kolom_aneh_lama')) {
        //     $table->dropColumn('kolom_aneh_lama');
        // }

        // --- TAMBAHKAN 3 KOLOM WAJIB ---

        // 1. Kolom untuk tahu siapa yang mengerjakan
        if (!Schema::hasColumn('exam_results', 'user_id')) {
            $table->foreignId('user_id')->constrained('users')->after('id');
        }

        // 2. Kolom untuk tahu ujian mana yang dikerjakan
        if (!Schema::hasColumn('exam_results', 'exam_id')) {
            $table->foreignId('exam_id')->constrained('exams')->after('user_id');
        }

        // 3. Kolom untuk menyimpan nilainya
        if (!Schema::hasColumn('exam_results', 'score')) {
            $table->integer('score')->after('exam_id');
        }
    });
}
    public function down(): void
    {
        Schema::table('exam_results', function (Blueprint $table) {
            //
        });
    }
};
