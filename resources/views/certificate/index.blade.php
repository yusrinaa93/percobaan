<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Course - Certificate</title>
    {{-- Menggunakan helper asset() Blade --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>
<div class="dashboard-container">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo Halal" class="sidebar-logo">
            <div class="sidebar-title">
                <span>Pelatihan</span>
                <span>Pendamping Proses Produk Halal</span>
            </div>
            <button class="sidebar-toggle" id="sidebar-toggle-close">&times;</button>
        </div>
        <nav class="sidebar-nav">
            <ul>
                {{-- Menggunakan helper route() untuk link --}}
                <li><a href="{{ route('courses') }}"><i class="fas fa-graduation-cap"></i><span>Courses</span></a></li>
                <li class="has-submenu">
                    <div class="menu-item-wrapper">
                        <a href="{{ route('my-courses') }}" class="menu-link"><i class="fas fa-book-open"></i><span>My courses</span></a>
                        <span class="submenu-toggle"><i class="fas fa-chevron-down submenu-arrow"></i></span>
                    </div>
                    <ul class="submenu">
                        <li><a href="{{ route('duty') }}"><i class="fas fa-tasks"></i><span>Duty</span></a></li>
                        <li><a href="{{ route('exam') }}"><i class="fas fa-pencil-alt"></i><span>Exam</span></a></li>
                        
                        {{-- Pastikan link ini mengarah ke route yang benar --}}
                        <li><a href="{{ route('certificate.index') }}" class="active"><i class="fas fa-certificate"></i><span>Certificate</span></a></li>
                    
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('account') }}"><i class="fas fa-user-circle"></i><span>Account</span></a>
        </div>
    </aside>

    <main class="main-content">
        <header class="main-header">
            <button class="sidebar-toggle" id="sidebar-toggle-open"><i class="fas fa-bars"></i></button>
            <nav>
                <ul>
                    <li><a href="/">HOME</a></li>
                    <li><a href="{{ route('courses') }}" class="active">COURSES</a></li>
                    <li><a href="/about">ABOUT</a></li>
                    <li><div class="profile-icon"><i class="fas fa-user"></i></div></li>
                </ul>
            </nav>
        </header>

        <section class="content-section">
            <h2>MY COURSE - CERTIFICATE</h2>
            <div class="content-card">
                <div class="search-bar">
                    <input type="text" placeholder="Search Certificate">
                    <button class="btn btn-search">Cari</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            {{-- Kolom diubah agar sesuai dengan data Pelatihan (Course) --}}
                            <th>NAMA PELATIHAN</th>
                            <th>STATUS SERTIFIKAT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- =============================================== --}}
                        {{-- PERUBAHAN UTAMA: Loop $courses (Pelatihan) --}}
                        {{-- =============================================== --}}
                        
                        {{-- Loop $courses (jamak) yang dikirim dari Controller --}}
                        @forelse ($courses as $course)
                            <tr>
                                {{-- Menampilkan nama pelatihan --}}
                                <td>{{ $course->title }}</td>
                                <td>
                                    {{-- Menampilkan status peluncuran sertifikat --}}
                                    @if ($course->is_certificate_active)
                                        <span style="color: green; font-weight: 500;">Tersedia</span>
                                    @else
                                        <span style="color: #888; font-style: italic;">Belum Tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Tombol ini mengarah ke route 'check' dengan ID Pelatihan --}}
                                    <a href="{{ route('certificate.check', $course->id) }}" class="btn btn-download">
                                        Unduh
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center;">Anda belum terdaftar di pelatihan manapun.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

{{-- Kode JavaScript Anda (Tidak diubah) --}}
<script>
    // ... Kode JS Anda tetap sama ...
    document.addEventListener('DOMContentLoaded', () => {
        const hasSubmenuItems = document.querySelectorAll('.has-submenu');
        
        hasSubmenuItems.forEach(item => {
            const activeSubmenuLink = item.querySelector('.submenu a.active');
            
            if (activeSubmenuLink) {
                item.classList.add('active');
                item.classList.add('active-page');
            } else if (item.classList.contains('active')) {
                item.classList.remove('active');
                item.classList.add('active-page');
            }
        });

        // ... sisa JS Anda ...
    });

    const sidebar = document.getElementById('sidebar');
    const sidebarToggleOpen = document.getElementById('sidebar-toggle-open');
    const sidebarToggleClose = document.getElementById('sidebar-toggle-close');

    if (sidebarToggleOpen) {
        sidebarToggleOpen.addEventListener('click', () => {
            sidebar.classList.add('active');
        });
    }

    if (sidebarToggleClose) {
        sidebarToggleClose.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });
    }

    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const parentLi = toggle.closest('.has-submenu');
            parentLi.classList.toggle('active');
        });
    });

    const menuLinks = document.querySelectorAll('.menu-link');
    menuLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            // Biarkan navigasi
        });
    });

    const hasSubmenuItems = document.querySelectorAll('.has-submenu');
    submenuToggles.forEach((toggle, index) => {
        toggle.addEventListener('click', () => {
            hasSubmenuItems.forEach((item, i) => {
                if (i !== index) {
                    item.classList.remove('active');
                }
            });
        });
    });
</script>
</body>
</html>
