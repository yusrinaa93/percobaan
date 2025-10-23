<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan form pendaftaran dan mengirim CSRF token ke view.
     */
    public function create()
    {
        // Ambil CSRF token yang sedang aktif
        $csrfToken = csrf_token(); 
        
        // Kirim token tersebut ke view dengan nama variabel 'csrf_token'
        return view('pendaftaran-kursus', ['csrf_token' => $csrfToken]);
    }

    /**
     * Menyimpan data pendaftar baru ke database.
     */
    public function store(Request $request)
    {
        // ... Method store Anda tidak perlu diubah sama sekali ...
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pendaftar,email',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'nomor_wa' => 'required|string|max:25',
            'alamat' => 'required|string',
        ]);

        try {
            Pendaftar::create($validatedData);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Gagal menyimpan data ke database.'
            ], 500);
        }
    }
}