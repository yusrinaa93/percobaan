<?php

// database/migrations/xxxx_add_score_to_duty_submissions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('duty_submissions', function (Blueprint $table) {
            // Tambahkan kolom 'score', boleh null, setelah kolom 'original_filename'
            $table->integer('score')->nullable()->default(0)->after('original_filename');
        });
    }

    public function down(): void
    {
        Schema::table('duty_submissions', function (Blueprint $table) {
            $table->dropColumn('score');
        });
    }
};