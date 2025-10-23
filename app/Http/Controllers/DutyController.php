<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Duty; // <-- Panggil model Duty
use App\Models\DutySubmission; // <-- Panggil model DutySubmission
use Illuminate\Support\Facades\Auth; // <-- Panggil helper Auth
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DutyController extends Controller
{
    /**
     * Menampilkan halaman "Duty" dengan data asli dari database.
     */
    public function index()
    {
        // 1. Ambil semua data tugas dari tabel 'duties', diurutkan dari yang terbaru
        $duties = Duty::latest()->get();
        
        // 2. Ambil ID pengguna yang sedang login
        $userId = Auth::id();

        // 3. Cek status pengumpulan untuk setiap tugas
        foreach ($duties as $duty) {
            // Cari di tabel 'duty_submissions' apakah ada catatan
            // yang cocok dengan user_id dan duty_id saat ini.
            // first() akan mengembalikan data submission jika ada, atau null jika tidak ada.
            $duty->submission = DutySubmission::where('user_id', $userId)
                                              ->where('duty_id', $duty->id)
                                              ->first();
        }

        // 4. Kirim variabel $duties yang sudah berisi informasi submission ke view
        return view('duty', ['duties' => $duties]);
    }

    /**
     * Handle file upload for a duty submission.
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        $userId = Auth::id();

        $duty = Duty::findOrFail($id);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        // Store under public/duties/{duty_id}/{timestamp}_{random}_{original}
        $filename = time() . '_' . Str::random(6) . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $path = $file->storeAs("duties/{$duty->id}", $filename, 'public');

        // Create or update a submission (one submission per user per duty)
        $submission = \App\Models\DutySubmission::updateOrCreate(
            ['user_id' => $userId, 'duty_id' => $duty->id],
            ['file_path' => $path, 'original_filename' => $originalName]
        );

        return redirect()->back()->with('status', 'File uploaded successfully.');
    }
}