<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Course - Exam</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    
    {{-- CSS TAMBAHAN --}}
    <style>
        .exam-list-card h3 { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .exam-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #f0f0f0; }
        .exam-item:last-child { border-bottom: none; }
        .exam-details h4 { margin: 0 0 5px 0; font-size: 1.1rem; }
        .exam-details p { margin: 0 0 5px 0; font-size: 0.9rem; color: #666; }
        .exam-details .question-count { font-size: 0.8rem; color: #888; font-weight: 500; }

        /* =================================================
          AWAL PERUBAHAN CSS
          Mengganti .btn-selesai (hijau) menjadi .btn-disabled (abu-abu)
        =================================================
        */
        .btn-disabled {
            display: inline-block;
            padding: 8px 20px; /* Samakan dengan padding .btn-start */
            border-radius: 20px; /* Samakan dengan radius .btn-start */
            
            background-color: #d8dee3; /* Warna abu-abu */
            color: #888;           /* Warna teks abu-abu */
            
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem; /* Samakan dengan font-size .btn-start */
            text-align: center;
            
            /* Ini yang penting: mengubah kursor jadi "dilarang" */
            cursor: not-allowed; 
        }
        /* =================================================
          AKHIR PERUBAHAN CSS
        =================================================
        */

    </style>
</head>
<body>
<div class="dashboard-container">
    {{-- Sidebar Anda (Tidak diubah) --}}
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
                <li class="has-submenu">
                    <div class="menu-item-wrapper">
                        <a href="{{ route('my-courses') }}" class="menu-link"><i class="fas fa-book-open"></i><span>My courses</span></a>
                        <span class="submenu-toggle"><i class="fas fa-chevron-down submenu-arrow"></i></span>
                    </div>
                    <ul class="submenu">
                        <li><a href="{{ route('duty') }}"><i class="fas fa-tasks"></i><span>Duty</span></a></li>
                        <li><a href="{{ route('exam') }}" class="active"><i class="fas fa-pencil-alt"></i><span>Exam</span></a></li>
                        <li><a href="{{ route('certificate') }}"><i class="fas fa-certificate"></i><span>Certificate</span></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('account') }}"><i class="fas fa-user-circle"></i><span>Account</span></a>
        </div>
    </aside>

    <main class="main-content">
        {{-- Header Anda (Tidak diubah) --}}
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

        {{-- INI BAGIAN YANG DIROMBAK --}}
        <section class="content-section">
            <h2>MY COURSE - EXAM</h2>
            <div class="content-card exam-list-card">
                <h3>Ujian yang Tersedia</h3>
                
                {{-- Controller mengirim $exams (jamak) --}}
                @forelse($exams as $exam)
                    <div class="exam-item">
                        <div class="exam-details">
                            <h4>{{ $exam->title }}</h4>
                            <p>{{ $exam->description ?? 'Tidak ada deskripsi.' }}</p>
                            <span class="question-count">{{ $exam->questions_count }} Soal</span>
                        </div>
                        <div class="exam-action">

                            {{-- 
                            =================================================
                              AWAL PERUBAHAN LOGIKA
                            =================================================
                            --}}
                            
                            @if ($exam->is_completed)
                                {{-- Jika sudah selesai, tampilkan "tombol" mati (disabled) --}}
                                <span class="btn-disabled">SELESAI</span>
                            @else
                                {{-- Jika belum, tampilkan tombol "START" yang aktif --}}
                                <a href="{{ route('exams.show', $exam->id) }}" class="btn btn-start">START</a>
                            @endif
                            
                            {{-- 
                            =================================================
                              AKHIR PERUBAHAN LOGIKA
                            =================================================
                            --}}

                        </div>
                    </div>
                @empty
                    <p>Tidak ada ujian yang tersedia saat ini.</p>
                @endforelse

            </div>
        </section>
        {{-- AKHIR BAGIAN YANG DIROMBAK --}}

    </main>
</div>

{{-- JavaScript Anda (Tidak diubah) --}}
<script>
    // ... (Semua JS Anda untuk sidebar toggle, dll) ...
    
    // Contoh JS (Jika Anda belum punya)
    document.getElementById('sidebar-toggle-open').addEventListener('click', () => {
        document.getElementById('sidebar').classList.add('active');
    });
    document.getElementById('sidebar-toggle-close').addEventListener('click', () => {
        document.getElementById('sidebar').classList.remove('active');
    });
    document.querySelectorAll('.has-submenu .submenu-toggle').forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            let parent = toggle.closest('.has-submenu');
            parent.classList.toggle('open');
        });
    });
</script>
</body>
</html>