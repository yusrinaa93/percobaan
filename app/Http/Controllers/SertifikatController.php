<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CourseRegistration;
use App\Models\Attendance;
use App\Models\ExamResult;
use App\Models\DutySubmission;
use App\Models\Course;

class SertifikatController extends Controller
{
    public function unduh(Request $request, $registration_id)
    {
        $registration = CourseRegistration::with('user', 'course')->findOrFail($registration_id);

        // Pastikan pemiliknya sama dengan user login
        if ($registration->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengunduh sertifikat ini.');
        }

        $userId = $registration->user_id;
        $course = $registration->course;

        // 1) Hitung jumlah presensi user untuk jadwal yang berkaitan dengan course
        // Asumsi: schedules.category menyimpan course title, atau schedules relate to course via other logic.
        // Simpel: hitung total presensi user keseluruhan (sebagai fallback).
        $attendanceCount = Attendance::where('user_id', $userId)->count();

        // 2) Ambil skor ujian terakhir user (jika ada)
        $examResult = ExamResult::where('user_id', $userId)->latest('created_at')->first();
        $examScore = $examResult?->score ?? null;

        // 3) Hitung rata-rata nilai tugas (jika ada)
        $dutyScores = DutySubmission::where('user_id', $userId)
                        ->whereNotNull('score')
                        ->pluck('score');
        $dutyAvg = $dutyScores->count() ? (int) round($dutyScores->avg()) : null;

        // 4) Tentukan kelulusan: presensi >=3, exam >=50, dutyAvg >=50 (jika ada duties)
        $passed = true;
        if ($attendanceCount < 3) $passed = false;
        if ($examScore === null || $examScore < 50) $passed = false;
        if ($dutyAvg !== null && $dutyAvg < 50) $passed = false;

        if (! $passed) {
            abort(403, 'Anda belum memenuhi syarat untuk menerima sertifikat.');
        }

        // Siapkan data untuk sertifikat
        $data = [
            'nama' => $registration->user->name,
            'pelatihan' => $course?->title ?? 'Pelatihan',
            'tanggal_pelatihan' => ($course?->start_date?->format('d M Y') ?? now()->format('d M Y')) . ' - ' . ($course?->end_date?->format('d M Y') ?? now()->format('d M Y')),
        ];

        $pdf = Pdf::loadView('sertifikat.template', $data);
        $pdf->setPaper('A4', 'landscape');

        $filename = 'Sertifikat - ' . $registration->user->name . '.pdf';
        return $pdf->stream($filename);
    }
}
