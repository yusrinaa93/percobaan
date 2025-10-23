<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course; // <-- Jangan lupa import User

class Certificate extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'user_id', 
        'title', 
        'serial_number',
        'course_id', // Opsional, tapi sangat disarankan
        'name_on_certificate',
        'ttl_on_certificate',
        'phone_on_certificate'
    ];

    /**
     * Relasi "belongsTo":
     * Sertifikat ini DIMILIKI OLEH satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
