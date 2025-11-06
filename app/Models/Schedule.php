<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Schedule extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'course_id',
        'category',
        'start_time', // <-- Perbarui ini
        'end_time',   // <-- Tambahkan ini
        'zoom_link',
    ];

    /**
     * Casts untuk mengubah tipe data secara otomatis.
     */
    protected $casts = [
        'start_time' => 'datetime', // <-- Pastikan ini ada
        'end_time' => 'datetime',   // <-- Pastikan ini ada
    ];
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function course() { return $this->belongsTo(Course::class); }
}
