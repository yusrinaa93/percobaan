<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'exam_id',
        'score',
    ];

    /**
     * Relasi untuk mengambil data user yang mengerjakan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi untuk mengambil data ujian yang dikerjakan.
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}