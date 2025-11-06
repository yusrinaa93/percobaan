<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Certificate; // (Model untuk menyimpan hasil sertifikat)
use App\Models\Course;      // (Model Pelatihan Anda)
use App\Models\ExamResult;  // (Asumsi model nilai Ujian)
use App\Models\DutySubmission; // (Model nilai Tugas)
use App\Models\Attendance; // (Asumsi model Presensi)
use App\Models\User;
use App\Models\Pendaftar; // (Untuk mengecek pendaftaran)
use Carbon\Carbon;

class CertificateController extends Controller
{
    /**
     * 1. Menampilkan Halaman DAFTAR PELATIHAN (Courses)
     */
    public function index()
    {
        $user = Auth::user();
        $registered_courses = []; 

        if ($user) {
            $isRegistered = Pendaftar::where('email', $user->email)->exists();
            if ($isRegistered) {
                $registered_courses = Course::all();
            }
        }

        return view('certificate.index', [
            'courses' => $registered_courses
        ]);
    }

    /**
     * 2. MENGECEK SYARAT KELULUSAN
     */
    public function check(Course $course)
    {
        $user = Auth::user();
        $pendaftarData = Pendaftar::where('email', $user->email)->first();

        // Cek apakah Admin sudah "meluncurkan" sertifikat
        if (!$course->is_certificate_active) {
            return view('certificate.gagal', ['reasons' => ['Sertifikat untuk pelatihan ini belum diluncurkan oleh Admin.']]);
        }

        // Hitung kelayakan untuk course ini (berlaku juga untuk cetak ulang)
        $examScore = ExamResult::where('user_id', $user->id)
            ->whereHas('exam', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->avg('score') ?? 0;

        $dutyScore = DutySubmission::where('user_id', $user->id)
            ->whereNotNull('score')
            ->whereHas('duty', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->avg('score') ?? 0;

        $attendanceCount = Attendance::where('user_id', $user->id)
            ->whereHas('schedule', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->count();

        // Kriteria lulus: exam >= 50, duty >= 50, presensi >= 3
        $syaratGagal = [];
        $examDisp = number_format((float) $examScore, 0);
        $dutyDisp = number_format((float) $dutyScore, 0);
        if ($examScore < 50) {
            $syaratGagal[] = "Nilai ujian minimum 50 (Nilai Anda: $examDisp)";
        }
        if ($dutyScore < 50) {
            $syaratGagal[] = "Nilai tugas minimum 50 (Nilai Anda: $dutyDisp)";
        }
        if ($attendanceCount < 3) {
            $syaratGagal[] = "Presensi minimum 3 kali (Presensi Anda: $attendanceCount)";
        }

        if (!empty($syaratGagal)) {
            // Tidak memenuhi syarat -> tampilkan alasan
            return view('certificate.gagal', ['reasons' => $syaratGagal]);
        }

        // Jika memenuhi syarat, tampilkan form (baik cetak pertama maupun ulang)
        $existingCertificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        return view('certificate.form', [
            'user' => $user,
            'course' => $course,
            'pendaftarData' => $pendaftarData,
            'existingData' => $existingCertificate,
        ]);
    }

    /**
     * 3. MEMBUAT DAN MENGUNDUH PDF
     */
    public function generate(Request $request, Course $course)
    {
        $user = Auth::user();

        // Recheck eligibility server-side to prevent bypass
        $examScore = ExamResult::where('user_id', $user->id)
            ->whereHas('exam', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->avg('score') ?? 0;

        $dutyScore = DutySubmission::where('user_id', $user->id)
            ->whereNotNull('score')
            ->whereHas('duty', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->avg('score') ?? 0;

        $attendanceCount = Attendance::where('user_id', $user->id)
            ->whereHas('schedule', function ($q) use ($course) { $q->where('course_id', $course->id); })
            ->count();

        if ($examScore < 50 || $dutyScore < 50 || $attendanceCount < 3) {
            return view('certificate.gagal', ['reasons' => [
                "Nilai ujian minimal 50 (Anda: $examScore)",
                "Nilai tugas minimal 50 (Anda: $dutyScore)",
                "Presensi minimal 3 (Anda: $attendanceCount)",
            ]]);
        }

        // 1. Ambil & Validasi data FINAL dari form
        $validatedData = $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string|max:25',
        ]);

        // 2. Buat Nomor Sertifikat unik (INI YANG DIPERBAIKI)
        $serial_number = $this->generateSerialNumber($course, $user); 

        // 3. SIMPAN DATA KE TABEL 'certificates'
        $certificate = Certificate::updateOrCreate(
            [
                // Kita cari berdasarkan 'user_id' DAN 'course_id'
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                // Data yang akan di-update atau di-create
                'title' => $course->title,
                'serial_number' => $serial_number,
                'name_on_certificate' => $validatedData['nama_sertifikat'], 
                'ttl_on_certificate' => $validatedData['tempat_lahir'] . ', ' . Carbon::parse($validatedData['tanggal_lahir'])->format('d-m-Y'),
                'phone_on_certificate' => $validatedData['no_hp'],
            ]
        );

        // 4. Siapkan data untuk template PDF
        $data = [
            'nama' => $certificate->name_on_certificate,
            'tempat_tanggal_lahir' => $certificate->ttl_on_certificate,
            'no_hp' => $certificate->phone_on_certificate,
            'serial_number' => $certificate->serial_number // (Jika perlu ditampilkan di PDF)
        ];

        // 5. Muat template Blade
        $pdf = Pdf::loadView('certificate.template', $data);
        $pdf->setPaper('letter', 'portrait'); // Menggunakan 'letter'

        return $pdf->download('Sertifikat-PPH-' . $user->name . '.pdf');
    }

    /**
     * ==========================================================
     * INI FUNGSI YANG SEHARUSNYA MEMBUAT NOMOR SERI BARU
     * ==========================================================
     * Helper function untuk membuat nomor seri unik
     */
    private function generateSerialNumber(Course $course, User $user)
    {
        // Cek dulu apakah sertifikat sudah ada dan punya nomor seri
        $existing = Certificate::where('user_id', $user->id)
                               ->where('course_id', $course->id)
                               ->first();
        
        // Jika sudah ada, JANGAN buat nomor baru, kembalikan nomor yang lama
        if ($existing && $existing->serial_number) {
            return $existing->serial_number;
        }

        // Jika belum ada, baru buat nomor seri baru
        $prefix = "D-13/PPH/IX/2023";
        $user_id_padded = str_pad($user->id, 4, '0', STR_PAD_LEFT); 

        // TAMBAHKAN ID KURSUS AGAR UNIK
        $course_id_padded = str_pad($course->id, 2, '0', STR_PAD_LEFT); // Menghasilkan '01', '02', dst.

        // Hasilnya: "D-13/PPH/IX/2023/01/0002" (Nomor baru yang tidak konflik)
        return $prefix . '/' . $course_id_padded . '/' . $user_id_padded;
    }
}
