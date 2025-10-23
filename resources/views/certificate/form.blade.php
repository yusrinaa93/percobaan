<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Data Sertifikat</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    {{-- (Link font, font-awesome, dll, bisa ditambahkan di sini) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    
    {{-- CSS untuk Halaman Ini --}}
    <style>
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .form-warning { background-color: #fffbe6; border: 1px solid #ffe58f; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
<div class="dashboard-container">
    {{-- 
      ASUMSI: Anda harus copy-paste <aside class="sidebar">...</aside> 
      dari file (misal: views/certificate/index.blade.php) ke sini
      agar layout-nya lengkap.
    --}}

<main class="main-content">
    <header class="main-header">
        {{-- 
          ASUMSI: Anda harus copy-paste <header class="main-header">...</header>
          dari file (misal: views/certificate/index.blade.php) ke sini
          agar layout-nya lengkap.
        --}}
    </header>

    <section class="content-section">
        <h2>MY COURSE - CERTIFICATE</h2>
        <div class="content-card">
            <h3>Verifikasi Data Diri Anda</h3>
            
            @if (isset($existingData))
                <p>Anda sudah pernah mengunduh sertifikat ini. Data Anda yang tersimpan adalah sebagai berikut.</p>
            @else
                <p>Selamat, Anda berhak mengunduh sertifikat. Pastikan data di bawah ini sudah benar.</p>
            @endif

            <div class="form-warning">
                <strong>PERHATIAN!</strong> Data ini akan dicetak di sertifikat. Pastikan tidak ada salah ketik.
            </div>

            {{-- Form mengarah ke route 'generate' dengan ID Pelatihan --}}
            <form action="{{ route('certificate.generate', $course->id) }}" method="POST" style="margin-top: 20px;">
                @csrf
                
                {{-- 
                ==========================================================
                  PERBAIKAN FINAL LOGIKA 'VALUE'
                ==========================================================
                Prioritas value:
                1. Data 'old' (jika validasi gagal)
                2. Data '$existingData' (jika cetak ulang)
                3. Data '$pendaftarData' (data pendaftaran asli)
                4. Data '$user' (sebagai fallback untuk nama)
                --}}

                <div class="form-group">
                    <label for="nama_sertifikat">Nama Lengkap (untuk Sertifikat)</label>
                    <input type="text" id="nama_sertifikat" name="nama_sertifikat" 
                           value="{{ old('nama_sertifikat', $existingData->name_on_certificate ?? $pendaftarData->nama ?? $user->name) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" 
                           value="{{ old('tempat_lahir', $existingData ? explode(',', $existingData->ttl_on_certificate)[0] : $pendaftarData->tempat_lahir ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" 
                           value="{{ old('tanggal_lahir', $existingData ? \Carbon\Carbon::parse(trim(explode(',', $existingData->ttl_on_certificate)[1] ?? ''))->format('Y-m-d') : ($pendaftarData->tanggal_lahir ? \Carbon\Carbon::parse($pendaftarData->tanggal_lahir)->format('Y-m-d') : '')) }}" required>
                </div>

                <div class="form-group">
                    <label for="no_hp">No. HP</label>
                    <input type="text" id="no_hp" name="no_hp" 
                           value="{{ old('no_hp', $existingData->phone_on_certificate ?? $pendaftarData->nomor_wa ?? '') }}" required>
                </div>
                
                {{-- ==========================================================
                  PERBAIKAN FINAL TOMBOL SUBMIT
                ========================================================== --}}
                @if (isset($existingData))
                    <button type="submit" class="btn btn-download">Cetak Ulang Sertifikat</button>
                @else
                    <button type="submit" class="btn btn-download">Setuju & Unduh Sertifikat</button>
                @endif

                <a href="{{ route('certificate.index') }}" class="btn" style="background-color: #aaa;">Kembali</a>
            </form>
            
        </div>
    </section>
</main>
</div>
 <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- FUNGSI DROPDOWN PROFIL (SESUAI CSS ANDA) ---
        const profileDropdown = document.querySelector('.profile-dropdown');
        if (profileDropdown) {
            const profileIcon = profileDropdown.querySelector('.profile-icon');
            const dropdownMenu = profileDropdown.querySelector('.dropdown-menu');

            profileIcon.addEventListener('click', function(event) {
                event.stopPropagation();
                // Toggle class 'show' pada elemen .dropdown-menu
                dropdownMenu.classList.toggle('show');
            });

            // Menutup dropdown jika klik di luar area
            document.addEventListener('click', function(event) {
                if (!profileDropdown.contains(event.target)) {
                    // Hapus class 'show' dari elemen .dropdown-menu
                    dropdownMenu.classList.remove('show');
                }
            });
        }

        // --- FUNGSI 1: OTOMATIS BUKA SUBMENU DI HALAMAN DASHBOARD ---
        const activeSubmenuLink = document.querySelector('.sidebar-nav .submenu a.active');
        const activeParentLink = document.querySelector('.sidebar-nav li.has-submenu.active');
        if (activeSubmenuLink || activeParentLink) {
            const parentLi = document.querySelector('li.has-submenu');
            if (parentLi) {
                parentLi.classList.add('open');
            }
        }

        // --- FUNGSI 2: BUKA/TUTUP SIDEBAR DI TAMPILAN HP ---
        const sidebar = document.getElementById('sidebar');
        const openToggle = document.getElementById('sidebar-toggle-open');
        const closeToggle = document.getElementById('sidebar-toggle-close');
        if (openToggle && closeToggle && sidebar) {
            openToggle.addEventListener('click', () => sidebar.classList.add('open'));
            closeToggle.addEventListener('click', () => sidebar.classList.remove('open'));
        }

        // --- FUNGSI 3: KLIK PANAH UNTUK BUKA/TUTUP SUBMENU ---
        document.querySelectorAll('.submenu-toggle').forEach(toggle => {
            toggle.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                const parentLi = this.closest('li.has-submenu');
                if (parentLi) {
                    parentLi.classList.toggle('open');
                }
            });
        });
    });
    </script>
</body>
</html>