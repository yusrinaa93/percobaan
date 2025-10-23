<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Option;
use App\Models\ExamResult; // <-- Pastikan ini nama Model Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Menampilkan halaman DAFTAR UJIAN (View 1)
     * Ini akan dipanggil oleh route('exam').
     */
    public function index()
    {
        // Ambil semua ujian, plus jumlah soalnya
        $exams = Exam::withCount('questions')->get();
        
        // Kirim data 'exams' (jamak) ke view 'exam.blade.php'
        return view('exam', compact('exams')); 
    }

    /**
     * Menampilkan halaman PENGERJAAN SOAL (View 2)
     * Ini akan dipanggil oleh route('exams.show').
     */
    public function show(Exam $exam)
    {
        // Ambil 1 ujian, beserta SEMUA soal DAN pilihan jawabannya
        $exam->load('questions.options'); 
        
        // Kirim data 'exam' (tunggal) ke view 'exam-show.blade.php'
        return view('exam-show', compact('exam'));
    }

    /**
     * Memproses jawaban dan menghitung skor (Logika Inti)
     * Ini akan dipanggil oleh route('exams.submit').
     */
    public function submit(Request $request, Exam $exam)
    {
        // 1. Ambil semua jawaban dari form
        $answers = $request->input('answers'); // Format: [question_id => option_id]
        
        $totalQuestions = $exam->questions->count();
        $correctAnswers = 0;

        // 2. Ambil semua ID pilihan jawaban yang benar untuk kuis ini
        $correctOptionIds = Option::whereIn('question_id', $exam->questions->pluck('id'))
                                  ->where('is_correct', true)
                                  ->pluck('id');
        
        // 3. Loop dan cek jawaban user
        if (!empty($answers)) {
            foreach ($answers as $questionId => $optionId) {
                // Jika ID jawaban user ada di daftar jawaban benar
                if ($correctOptionIds->contains($optionId)) {
                    $correctAnswers++;
                }
            }
        }

        // 4. Hitung skor
        $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // 5. Simpan ke database
        // Pastikan Model ExamResult punya $fillable!
        $result = ExamResult::create([
            'user_id' => Auth::id(), // ID user yang sedang login
            'exam_id' => $exam->id,
            'score'   => $score,
        ]);

        // 6. Arahkan ke halaman hasil
        return redirect()->route('exams.result', $result->id);
    }

    /**
     * Menampilkan halaman HASIL UJIAN (View 3)
     * Ini akan dipanggil oleh route('exams.result').
     */
    public function result(ExamResult $examResult) // Ganti nama variabel
    {
        // Pastikan user hanya bisa lihat nilainya sendiri
        if ($examResult->user_id != Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengakses halaman ini.');
        }
        
        // Kirim data 'examResult' ke view 'exam-result.blade.php'
        return view('exam-result', ['result' => $examResult]); // Kirim sbg 'result'
    }
}