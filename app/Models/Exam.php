<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Question; // <-- PASTIKAN INI ADA
use App\Models\ExamResult; // <-- GANTI DENGAN NAMA MODEL HASIL ANDA

class Exam extends Model
{
    use HasFactory;

    // ... (properti $fillable, dll. biarkan saja) ...
    protected $fillable = [
        'title',
        'description',
        'course_id',
    ];

    /**
     * ==========================================================
     * FUNGSI YANG HILANG (INI SOLUSINYA)
     * ==========================================================
     * Relasi untuk menghitung jumlah soal (dipakai oleh withCount).
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * ==========================================================
     * KODE DARI MASALAH SEBELUMNYA
     * ==========================================================
     * Relasi ke model hasil ujian Anda.
     */
    public function results()
    {
        // Ganti ExamResult::class dengan model hasil ujian Anda
        return $this->hasMany(ExamResult::class); 
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Accessor untuk mengecek apakah ujian sudah selesai.
     */
    public function getIsCompletedAttribute()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->results()->where('user_id', Auth::id())->exists();
    }
}