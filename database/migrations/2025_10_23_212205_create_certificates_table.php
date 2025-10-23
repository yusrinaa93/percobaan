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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            
            // Ini akan membuat kolom 'user_id' yang terhubung ke tabel 'users'
            // 'constrained' = terhubung ke tabel users
            // 'cascadeOnDelete' = jika user dihapus, sertifikatnya ikut terhapus
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Kolom dari $fillable Anda
            $table->string('title'); // Untuk nama pelatihan, misal "Pelatihan PPH"
            $table->string('serial_number')->unique(); // Nomor sertifikat, unik
            
            $table->timestamps(); // Membuat kolom created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
