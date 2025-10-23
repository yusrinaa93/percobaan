<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    /**
     * Nama tabel database.
     */
    protected $table = 'pendaftar';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'nama',
        'email',
        'tempat_lahir',
        'tanggal_lahir',
        'nomor_wa',
        'alamat',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}

// Relasi ke Pelatihan
public function pelatihan()
{
    // Ganti 'Pelatihan::class' jika nama model pelatihanmu beda
    return $this->belongsTo(Pelatihan::class); 
}
}