<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Pelatihan Halal</title>
    {{-- Menggunakan helper asset() Blade --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>

<style>
    /* CSS Anda tidak perlu diubah */
    .btn-disabled {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background-color: #a0a0a0; /* Warna abu-abu */
        color: #ffffff;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        cursor: not-allowed; /* Ubah cursor */
        opacity: 0.7;
    }
    .btn-disabled i {
        margin-right: 8px;
    }
</style>

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
                {{-- Menggunakan helper route() untuk link yang lebih baik --}}
                <li class="active"><a href="{{ route('courses') }}"><i class="fas fa-graduation-cap"></i><span>Courses</span></a></li>
                <li><a href="{{ route('my-courses') }}"><i class="fas fa-book-open"></i><span>My courses</span></a></li>
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
                    
                    {{-- Mengganti sintaks PHP if/else dengan Blade @auth --}}
                    @auth
                        <li class="profile-dropdown">
                            <div class="profile-icon" style="cursor: pointer;">
                                <i class="fas fa-user"></i>
                            </div>
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
        
        {{-- ========================================================== --}}
        {{-- MULAI PERUBAHAN: KODE DINAMIS --}}
        {{-- ========================================================== --}}
        <section class="content-section">
            <h2>COURSES</h2>

            {{-- Loop $courses yang dikirim dari CourseController --}}
            @forelse ($courses as $course)
                <div class="course-item-card">
                    @php($cover = $course->image_path ? asset('storage/'.$course->image_path) : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&q=80')
                    <img src="{{ $cover }}" alt="Gambar Pelatihan" class="course-card-image">
                    <div class="course-card-content">
                        
                        {{-- Judul dinamis dari database --}}
                        <h3>{{ $course->title }}</h3> 
                        
                        <p class="course-card-category">Pelatihan Pendamping</p>
                        
                        {{-- Deskripsi dinamis dari database. 
                             Gunakan {!! !!} agar format dari Rich Editor (admin) tampil --}}
                        <div>{!! $course->description !!}</div>
                        
                        {{-- Logika Pendaftaran (ini sudah benar dari file Anda) --}}
                        @if (isset($registeredCourseIds) && $registeredCourseIds->contains($course->id))
                            <div class="btn btn-disabled">
                                <i class="fas fa-check-circle"></i>
                                <span>ANDA SUDAH TERDAFTAR</span>
                            </div>
                        @else
                            <a href="{{ route('course.register.form', ['course' => $course->id]) }}" class="btn btn-register">
                                <i class="fas fa-clipboard-check"></i>
                                <span>REGISTER COURSE</span>
                            </a>
                        @endif
                    </div>
                </div>
            
            {{-- Ini yang tampil jika tidak ada kursus di database --}}
            @empty
                <div class="course-item-card">
                    <div class="course-card-content">
                        <p>Belum ada kursus yang tersedia saat ini.</p>
                    </div>
                </div>
            @endforelse

        </section>
        {{-- ========================================================== --}}
        {{-- AKHIR PERUBAHAN --}}
        {{-- ========================================================== --}}

    </main>
</div>

{{-- Kode JavaScript tidak perlu diubah --}}
<script>
    // --- SIDEBAR TOGGLE ---
    document.addEventListener('DOMContentLoaded', function() {});
    const sidebar = document.getElementById('sidebar');
    const openToggle = document.getElementById('sidebar-toggle-open');
    const closeToggle = document.getElementById('sidebar-toggle-close');
    if (openToggle && closeToggle && sidebar) {
        openToggle.addEventListener('click', () => sidebar.classList.add('open'));
        closeToggle.addEventListener('click', () => sidebar.classList.remove('open'));
    }
    // tidak ada submenu lagi

 window.addEventListener('load', function() {
    const profileDropdown = document.querySelector('.profile-dropdown');
    if (!profileDropdown) return;

    const profileIcon = profileDropdown.querySelector('.profile-icon');
    const dropdownMenu = profileDropdown.querySelector('.dropdown-menu');

    profileIcon.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdownMenu.classList.toggle('show');
    });

    document.addEventListener('click', function(e) {
        if (!profileDropdown.contains(e.target)) {
            dropdownMenu.classList.remove('show');
        }
    });
});
</script>
</body>
</html>