<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- WAJIB ADA: Token keamanan untuk fungsi presensi --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>My Courses - Pelatihan Halal</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <li><a href="{{ route('courses') }}"><i class="fas fa-graduation-cap"></i><span>Courses</span></a></li>
                <li class="active"><a href="{{ route('my-courses') }}"><i class="fas fa-book-open"></i><span>My courses</span></a></li>
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
                    @auth
                        <li class="profile-dropdown">
                            <div class="profile-icon" style="cursor: pointer;"><i class="fas fa-user"></i></div>
                            <ul class="dropdown-menu">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">LOGIN</a></li>
                    @endauth
                </ul>
            </nav>
        </header>
        <section class="content-section">
            <h2>MY COURSE</h2>

            @forelse ($courses as $course)
                <div class="course-item-card">
                    <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&q=80" alt="Course Image" class="course-card-image">
                    <div class="course-card-content">
                        <h3>{{ $course->title }}</h3>
                        <p class="course-card-category">Pelatihan Pendamping</p>
                        <div class="progress-wrapper">
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                                <span>Progress</span>
                                <span>0%</span>
                            </div>
                            <div class="progress-bar" style="height:10px;background:#e5e7eb;border-radius:6px;overflow:hidden;">
                                <div style="width:0%;height:100%;background:#10b981;"></div>
                            </div>
                        </div>
                        <div style="margin-top:16px;">
                            <a href="{{ route('my-courses.show', $course->id) }}" class="btn btn-register"><span>LANJUTKAN BELAJAR</span></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="content-card" style="text-align:center;">Belum ada kursus yang Anda ambil.</div>
            @endforelse
        </section>
    </main>
</div>

{{-- Kode JavaScript Final --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- FUNGSI 1: BUKA/TUTUP SIDEBAR DI TAMPILAN HP ---
    const sidebar = document.getElementById('sidebar');
    const openToggle = document.getElementById('sidebar-toggle-open');
    const closeToggle = document.getElementById('sidebar-toggle-close');
    if (openToggle && closeToggle && sidebar) {
        openToggle.addEventListener('click', () => sidebar.classList.add('open'));
        closeToggle.addEventListener('click', () => sidebar.classList.remove('open'));
    }

    // --- FUNGSI 2: KLIK PANAH UNTUK BUKA/TUTUP SUBMENU ---
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

    // --- FUNGSI 3: DROPDOWN PROFIL ---
    const profileDropdown = document.querySelector('.profile-dropdown');
    if (profileDropdown) {
        const profileIcon = profileDropdown.querySelector('.profile-icon');
        const dropdownMenu = profileDropdown.querySelector('.dropdown-menu');
        profileIcon.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });
        document.addEventListener('click', function(event) {
            if (!profileDropdown.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    }

    // (Tidak ada interaksi khusus di halaman ini)
});
</script>
</body>
</html>