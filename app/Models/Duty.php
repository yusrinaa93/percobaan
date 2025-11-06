<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duty extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Kolom-kolom ini diizinkan untuk diisi melalui form.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'name',
        'description',
        'deadline',
    ];

    /**
     * Mengatur tipe data atribut secara otomatis.
     * Ini akan mengubah 'deadline' menjadi objek Carbon yang lebih mudah dikelola.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Mendefinisikan relasi "One-to-Many": Satu Tugas (Duty) memiliki banyak Pengumpulan (Submissions).
     * Ini memungkinkan kita untuk memanggil $duty->submissions.
     */
    public function submissions()
    {
        return $this->hasMany(DutySubmission::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}