<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    // Tambahkan 'option_text' ke dalam array ini
    protected $fillable = [
        'question_id', 
        'option_text', 
        'is_correct'
    ];
}