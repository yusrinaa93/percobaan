<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MyCourseController;
use App\Http\Controllers\DutyController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ExamController;


// --- RUTE PUBLIK (Dapat diakses siapa saja) ---

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

// Rute untuk menampilkan form pendaftaran kursus (opsional pilih course)
Route::get('/pendaftaran-kursus/{course?}', [CourseRegistrationController::class, 'create'])->name('course.register.form');

// Rute untuk menyimpan data dari form pendaftaran kursus
Route::post('/pendaftaran-kursus', [CourseRegistrationController::class, 'store'])->name('course.register.store');

// Rute untuk menampilkan form register dan login PENGGONA
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Rute untuk memproses data register dan login PENGGONA
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/presence', [PresenceController::class, 'store'])->name('presence.store');


// --- RUTE TERPROTEKSI (Hanya untuk pengguna yang sudah login) ---

Route::middleware('auth')->group(function () {
    // INI BAGIAN YANG DIPERBAIKI
    Route::get('/courses', [CourseController::class, 'index'])->name('courses');


Route::get('/my-courses', [MyCourseController::class, 'index'])->name('my-courses');

Route::get('/duty', [DutyController::class, 'index'])->name('duty');
    
    // Route to handle duty uploads
    Route::post('/duty/{id}/upload', [DutyController::class, 'upload'])->name('duty.upload');

Route::get('/my-courses/exam', [ExamController::class, 'index'])->name('exam');
// Taruh route dinamis SETELAH route spesifik agar tidak tertangkap sebagai parameter
Route::get('/my-courses/{course}', [MyCourseController::class, 'show'])->name('my-courses.show');
Route::get('/exams/start/{exam}', [ExamController::class, 'show'])->name('exams.show');
Route::post('/exams/submit/{exam}', [ExamController::class, 'submit'])->name('exams.submit');
Route::get('/exams/result/{examResult}', [ExamController::class, 'result'])->name('exams.result');

Route::get('/certificate', [CertificateController::class, 'index'])->name('certificate');

    // Route to download sertifikat (by registration id)
    Route::get('/sertifikat/unduh/{registration_id}', [App\Http\Controllers\SertifikatController::class, 'unduh'])
        ->name('sertifikat.unduh');

    Route::get('/account', function () {
        return view('account');
    })->name('account');
});

// 1. Halaman yang menampilkan DAFTAR PELATIHAN (bukan sertifikat)
Route::get('/my-courses/certificate', [CertificateController::class, 'index'])
     ->name('certificate.index');

// 2. Route yang dipanggil saat tombol "Unduh" diklik (Mengecek SYARAT)
//    Kita ganti parameternya menjadi {course}
Route::get('/my-courses/certificate/{course}/check', [CertificateController::class, 'check'])
     ->name('certificate.check');

// 3. Route yang dipanggil saat form verifikasi di-submit (Membuat PDF)
//    Kita ganti juga parameternya menjadi {course}
Route::post('/my-courses/certificate/{course}/generate', [CertificateController::class, 'generate'])
     ->name('certificate.generate');

