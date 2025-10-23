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
    public function create(Request $request)
    {
        // Ambil CSRF token dari session
        $csrfToken = $request->session()->token();
        
        // Ambil data user yang sedang login
        $user = Auth::user();
        
        // Kirim CSRF token DAN data user ke view
        return view('pendaftaran-kursus', [
            'csrf_token' => $csrfToken,
            'user' => $user
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
            'email' => 'required|email|unique:pendaftar,email',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'nomor_wa' => 'required|string|max:25',
            'alamat' => 'required|string',
        ]);

        try {
            // 2. Simpan data ke database menggunakan Model
            Pendaftar::create($validatedData);

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