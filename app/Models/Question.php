<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
    use HasFactory;
    protected $fillable = ['exam_id', 'question_text'];

    // Relasi ke tabel exams
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relasi ke tabel options
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}