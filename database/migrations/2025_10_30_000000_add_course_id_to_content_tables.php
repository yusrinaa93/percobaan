<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // schedules
        if (Schema::hasTable('schedules') && !Schema::hasColumn('schedules', 'course_id')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            });
        }

        // duties
        if (Schema::hasTable('duties') && !Schema::hasColumn('duties', 'course_id')) {
            Schema::table('duties', function (Blueprint $table) {
                $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            });
        }

        // exams
        if (Schema::hasTable('exams') && !Schema::hasColumn('exams', 'course_id')) {
            Schema::table('exams', function (Blueprint $table) {
                $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('schedules') && Schema::hasColumn('schedules', 'course_id')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->dropConstrainedForeignId('course_id');
            });
        }
        if (Schema::hasTable('duties') && Schema::hasColumn('duties', 'course_id')) {
            Schema::table('duties', function (Blueprint $table) {
                $table->dropConstrainedForeignId('course_id');
            });
        }
        if (Schema::hasTable('exams') && Schema::hasColumn('exams', 'course_id')) {
            Schema::table('exams', function (Blueprint $table) {
                $table->dropConstrainedForeignId('course_id');
            });
        }
    }
};


