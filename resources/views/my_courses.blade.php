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
                <li class="has-submenu active">
                    <div class="menu-item-wrapper">
                        <a href="{{ route('my-courses') }}" class="menu-link"><i class="fas fa-book-open"></i><span>My courses</span></a>
                        <span class="submenu-toggle"><i class="fas fa-chevron-down submenu-arrow"></i></span>
                    </div>
                    <ul class="submenu">
                        <li><a href="{{ route('duty') }}"><i class="fas fa-tasks"></i><span>Duty</span></a></li>
                        <li><a href="{{ route('exam') }}"><i class="fas fa-pencil-alt"></i><span>Exam</span></a></li>
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
            {{-- Tabel Jadwal (JOIN ZOOM) --}}
            <div class="content-card">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th> <th>DATE</th> <th>TIME</th> <th>CATEGORY</th> <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->id }}</td>
                                <td>{{ $schedule->start_time->format('l, d F Y') }}</td>
                                <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                                <td>{{ $schedule->category }}</td>
                                <td><a href="{{ $schedule->zoom_link }}" target="_blank" class="btn btn-zoom">JOIN ZOOM</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Belum ada jadwal yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tabel Materi (PRESENSI) --}}
            <div class="content-card">
                <div class="search-bar">
                    <input type="text" placeholder="Search for training sessions">
                    <button class="btn btn-search">Cari</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th> <th>DATE</th> <th>TIME</th> <th>MATERI</th> <th>TIME PRESENCE</th> <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                         @forelse ($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->id }}</td>
                                <td>{{ $schedule->start_time->format('l, d M Y') }}</td>
                                <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                                <td>{{ $schedule->category }}</td>
                                <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                                <td>
                                    {{-- Logika Final Tombol Presensi --}}
                                    @if($schedule->has_attended)
                                        <button class="btn btn-info" disabled>
                                            <i class="fas fa-check-circle"></i> SUDAH PRESENSI
                                        </button>
                                    @elseif($schedule->is_presence_active)
                                        <a href="#" class="btn btn-presence" data-schedule-id="{{ $schedule->id }}">PRESENSI</a>
                                    @else
                                        <button class="btn btn-disabled" disabled>PRESENSI DITUTUP</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">Belum ada materi yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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

    // --- FUNGSI 4: LOGIKA TOMBOL PRESENSI ---
    document.querySelectorAll('.btn-presence').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 

            const scheduleId = this.dataset.scheduleId;
            const buttonElement = this;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('presence.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    schedule_id: scheduleId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server merespons dengan error!');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Anda telah berhasil melakukan presensi.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Ubah tombol menjadi 'SUDAH PRESENSI' dengan warna biru
                    buttonElement.outerHTML = `
                        <button class="btn btn-info" disabled>
                            <i class="fas fa-check-circle"></i> SUDAH PRESENSI
                        </button>
                    `;
                } else {
                    Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Tidak dapat terhubung ke server.', 'error');
            });
        });
    });
});
</script>
</body>
</html>