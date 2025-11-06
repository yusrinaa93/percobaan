<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Auth; // <-- Pastikan ini ada

class CourseRegistrationController extends Controller
{
    /**
     * Menampilkan form pendaftaran dan mengirim data user yang login.
     */
    public function create(Request $request, $course = null)
    {
        // Ambil CSRF token dari session
        $csrfToken = $request->session()->token();
        
        // Ambil data user yang sedang login
        $user = Auth::user();
        
        // Kirim CSRF token, data user, dan daftar kursus ke view
        $courses = \App\Models\Course::all();
        return view('pendaftaran-kursus', [
            'csrf_token' => $csrfToken,
            'user' => $user,
            'selected_course_id' => $course,
            'courses' => $courses,
        ]);
    }

    /**
     * Menyimpan data dari form pendaftaran kursus.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            // Email tidak perlu unique agar bisa daftar beberapa pelatihan
            'email' => 'required|email',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'nomor_wa' => 'required|string|max:25',
            'alamat' => 'required|string',
            'course_id' => 'required|exists:courses,id',
        ]);

        try {
            // 2. Simpan data ke database menggunakan Model
            // Simpan atau perbarui data pendaftar berdasarkan email
            Pendaftar::updateOrCreate(
                ['email' => $validatedData['email']],
                [
                    'nama' => $validatedData['nama'],
                    'tempat_lahir' => $validatedData['tempat_lahir'],
                    'tanggal_lahir' => $validatedData['tanggal_lahir'],
                    'nomor_wa' => $validatedData['nomor_wa'],
                    'alamat' => $validatedData['alamat'],
                ]
            );

            // Tambahkan ke course_registrations agar terhubung dengan course spesifik
            if (Auth::check()) {
                \App\Models\CourseRegistration::firstOrCreate([
                    'user_id' => Auth::id(),
                    'course_id' => $validatedData['course_id'],
                ], [
                    'nik' => $request->input('nik', ''),
                    'no_hp' => $validatedData['nomor_wa'],
                    'tempat_lahir' => $validatedData['tempat_lahir'],
                    'tanggal_lahir' => $validatedData['tanggal_lahir'],
                ]);
            }

            // 3. Kirim balasan sukses dalam format JSON
            return response()->json(['status' => 'success', 'message' => 'Pendaftaran berhasil!']);

        } catch (\Exception $e) {
            // 4. Jika gagal, kirim balasan error dalam format JSON
            return response()->json([
                'status' => 'error', 
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
}