<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Ditambahkan agar bisa diisi saat membuat user admin
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mengatur tipe data atribut secara otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Memastikan is_admin selalu true/false
        ];
    }
    public function certificates()
    {   
    // Asumsi 1 user bisa punya banyak sertifikat
        return $this->hasMany(Certificate::class);
    }
    /**
     * Fungsi yang dibutuhkan oleh Filament untuk memeriksa
     * apakah seorang pengguna boleh mengakses panel admin.
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Izinkan akses hanya jika pengguna memiliki is_admin = true.
        // (bool) memastikan nilai NULL atau 0 akan menjadi false.
        return (bool) $this->is_admin;
    }
}