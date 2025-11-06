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
        $registeredCourseIds = collect();
        $courses = [];

        // Cek apakah ada pengguna yang sedang login
        if (Auth::check()) {
            $registeredCourseIds = \App\Models\CourseRegistration::where('user_id', Auth::id())
                ->pluck('course_id');
        }

        // AMBIL SEMUA KURSUS DARI DATABASE
        // (Ini yang akan kita kirim ke view)
        $courses = Course::all();

        // Kirim SEMUA variabel ke view
        return view('courses', [
            'registeredCourseIds' => $registeredCourseIds,
            'courses' => $courses
        ]);
    }
}