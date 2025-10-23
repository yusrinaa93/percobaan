<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftar;
use App\Models\Course; // <-- TAMBAHKAN INI

class CourseController extends Controller
{
    /**
     * Menampilkan halaman daftar kursus.
     */
    public function index()
    {
        $isRegistered = false; // Default: anggap pengguna belum terdaftar
        $courses = []; // Default: kursus kosong

        // Cek apakah ada pengguna yang sedang login
        if (Auth::check()) {
            // Ambil email pengguna yang sedang login
            $userEmail = Auth::user()->email;
            
            // Cek apakah email tersebut ada di tabel 'pendaftar'
            $isRegistered = Pendaftar::where('email', $userEmail)->exists();
        }

        // AMBIL SEMUA KURSUS DARI DATABASE
        // (Ini yang akan kita kirim ke view)
        $courses = Course::all();

        // Kirim SEMUA variabel ke view
        return view('courses', [
            'isRegistered' => $isRegistered,
            'courses' => $courses // <-- KIRIM DATA KURSUS
        ]);
    }
}