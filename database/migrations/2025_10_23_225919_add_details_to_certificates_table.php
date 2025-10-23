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
        // Perintah untuk MENAMBAH kolom baru
        Schema::table('certificates', function (Blueprint $table) {
            
            // Tambahkan kolom untuk ID kursus (sangat disarankan)
            $table->foreignId('course_id')
                  ->nullable()
                  ->after('user_id') // Letakkan setelah user_id
                  ->constrained('courses') // Hubungkan ke tabel 'courses'
                  ->onDelete('set null');

            // Tambahkan 3 kolom yang hilang
            $table->string('name_on_certificate')->nullable()->after('serial_number');
            $table->string('ttl_on_certificate')->nullable()->after('name_on_certificate');
            $table->string('phone_on_certificate')->nullable()->after('ttl_on_certificate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk MENGHAPUS kolom jika di-rollback
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn([
                'course_id',
                'name_on_certificate',
                'ttl_on_certificate',
                'phone_on_certificate'
            ]);
        });
    }
};