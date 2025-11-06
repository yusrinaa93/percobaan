<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'title',
        'image_path',
        'description',
        'start_date',
        'end_date',
        'is_certificate_active',
    ];

    // Optional accessor to support older blades using 'judul'
    public function getJudulAttribute()
    {
        return $this->title;
    }
}
