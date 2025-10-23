<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_xxxxxx_create_courses_table.php

public function up(): void
{
    Schema::create('courses', function (Blueprint $table) {
        $table->id(); // Membuat kolom ID otomatis
        $table->string('title'); // Kolom untuk judul pelatihan
        $table->text('description'); // Kolom untuk deskripsi
        $table->date('start_date'); // Kolom untuk tanggal mulai
        $table->date('end_date'); // Kolom untuk tanggal selesai
        $table->timestamps(); // Membuat kolom created_at dan updated_at otomatis
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
