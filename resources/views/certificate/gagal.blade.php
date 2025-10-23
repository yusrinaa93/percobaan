<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gagal Unduh Sertifikat</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    {{-- (Copy semua <link> dari file index.blade.php Anda) --}}
</head>
<body>
<div class="dashboard-container">
    <aside class="sidebar" id="sidebar">
        {{-- (Copy-paste SELURUH kode <aside> dari file index.blade.php) --}}
    </aside>

    <main class="main-content">
        <header class="main-header">
            {{-- (Copy-paste SELURUH kode <header> dari file index.blade.php) --}}
        </header>

        <section class="content-section">
            <h2>MY COURSE - CERTIFICATE</h2>
            <div class="content-card">
                <h3>Maaf, Anda Belum Memenuhi Syarat</h3>
                <p>Anda belum dapat mengunduh sertifikat karena alasan berikut:</p>
                
                <ul style="color: red; margin-left: 20px;">
                    @foreach ($reasons as $reason)
                        <li>{{ $reason }}</li>
                    @endforeach
                </ul>
                
                <p style="margin-top: 20px;">
                    Silakan perbaiki nilai Anda atau hubungi admin jika ada kendala.
                </p>
                <a href="{{ route('certificate.index') }}" class="btn">&laquo; Kembali</a>
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