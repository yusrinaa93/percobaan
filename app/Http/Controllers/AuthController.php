<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // --- FUNGSI UNTUK MENAMPILKAN HALAMAN ---

    public function showRegistrationForm()
    {
        // Cukup tampilkan view register.php
        return view('register');
    }

    public function showLoginForm()
    {
        // Cukup tampilkan view login.php
        return view('login');
    }

    // --- FUNGSI UNTUK MEMPROSES DATA ---

    public function register(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 2. Buat user baru di tabel 'users'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password!
        ]);

        // 3. Setelah berhasil, arahkan pengguna ke halaman login
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba lakukan proses login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Jika berhasil, arahkan ke halaman 'courses'
            return redirect()->intended('/courses');
        }

        // 4. Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }
        public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Arahkan ke halaman utama setelah logout
    }
}
