<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Course - Duty</title>
    {{-- Menggunakan helper asset() Blade --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>
<div class="dashboard-container">
    {{-- Sidebar (disarankan untuk dipisah ke dalam file partials/sidebar.blade.php) --}}
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
                        <li><a href="{{ route('duty') }}" class="active"><i class="fas fa-tasks"></i><span>Duty</span></a></li>
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
        {{-- Header (disarankan untuk dipisah ke dalam file partials/header.blade.php) --}}
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
            <h2>MY COURSE - DUTY</h2>
            <div class="content-card">
                <div class="search-bar">
                    <input type="text" placeholder="Search Duty">
                    <button class="btn btn-search">Cari</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>DESCRIPTION</th>
                            <th>DEADLINE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Mengganti data statis dengan loop Blade --}}
                        {{-- Anggap saja $duties dikirim dari Controller --}}
                        @forelse ($duties as $duty)
                            <tr>
                                <td>{{ $duty->id }}</td>
                                <td>{{ $duty->name }}</td>
                          {{-- NOTE: description may contain HTML (saved from RichEditor). Render as raw HTML. 
                              Be careful with XSS: sanitize input on save (e.g. use HTMLPurifier) if content comes from untrusted users. --}}
                          <td>{!! $duty->description !!}</td>
                                <td>{{ $duty->deadline->format('l, d F Y') }}</td>
                                <td>
                                    @if(!empty($duty->submission) && !empty($duty->submission->file_path))
                                        <div class="action-cell">
                                            <div class="submission-right">
                                                <a href="{{ $duty->submission->download_url }}" target="_blank" class="btn btn-zoom btn-small">DOWNLOAD</a>
                                            </div>
                                            <div class="submission-filename">{{ $duty->submission->original_filename }}</div>
                                        </div>
                                    @else
                                        <div class="action-cell">
                                            <div class="submission-right">
                                                <button class="btn btn-zoom btn-small open-upload" data-duty-id="{{ $duty->id }}">UPLOAD</button>
                                            </div>
                                            <div class="submission-filename">&nbsp;</div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">No duties found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

{{-- Kode JavaScript tidak perlu diubah --}}
<script>
    // Cek apakah ada submenu item yang aktif, jika ada buka dropdown otomatis

document.addEventListener('DOMContentLoaded', () => {

    const hasSubmenuItems = document.querySelectorAll('.has-submenu');

   

    hasSubmenuItems.forEach(item => {

        // Cek apakah ada link aktif di dalam submenu

        const activeSubmenuLink = item.querySelector('.submenu a.active');

       

        if (activeSubmenuLink) {

            // Jika ada submenu yang aktif, buka dropdown dan tambahkan class active-page

            item.classList.add('active');

            item.classList.add('active-page');

        } else if (item.classList.contains('active')) {

            // Jika parent menu yang aktif (My courses), ganti dengan active-page saja

            item.classList.remove('active');

            item.classList.add('active-page');

        }

    });

});



// Toggle Sidebar for Mobile

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



// Toggle Submenu Dropdown

const submenuToggles = document.querySelectorAll('.submenu-toggle');



submenuToggles.forEach(toggle => {

    toggle.addEventListener('click', (e) => {

        e.preventDefault();

        e.stopPropagation();

       

        const parentLi = toggle.closest('.has-submenu');

       

        // Toggle active class untuk dropdown

        parentLi.classList.toggle('active');

    });

});



// Mencegah link menu dari menutup submenu ketika diklik

const menuLinks = document.querySelectorAll('.menu-link');

menuLinks.forEach(link => {

    link.addEventListener('click', (e) => {

        // Izinkan navigasi tanpa toggle submenu

        // Jika ingin mencegah navigasi, uncomment baris di bawah

        // e.preventDefault();

    });

});



// Optional: Tutup submenu lain ketika membuka submenu baru

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
<!-- Upload Modal -->
<div class="modal-backdrop" id="uploadModal">
    <div class="modal-card" role="dialog" aria-modal="true">
        <button class="modal-close" id="modalClose">&times;</button>
        <h3>Upload Tugas</h3>
        <p style="margin:0 0 10px;color:#666;font-size:0.95rem">Pilih file yang ingin kamu unggah untuk tugas ini. Maks 10 MB.</p>
        <form id="uploadForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-file-input">
                <input type="file" name="file" required>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn" id="modalCancel">BATAL</button>
                <button type="submit" class="btn btn-zoom">UPLOAD</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('uploadModal');
    const openButtons = document.querySelectorAll('.open-upload');
    const closeBtn = document.getElementById('modalClose');
    const cancelBtn = document.getElementById('modalCancel');
    const uploadForm = document.getElementById('uploadForm');

    function openModalForDuty(dutyId) {
        // set form action to the correct route
        uploadForm.action = `/duty/${dutyId}/upload`;
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
        // clear file input
        const input = uploadForm.querySelector('input[type=file]');
        if (input) input.value = '';
    }

    openButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const dutyId = btn.getAttribute('data-duty-id');
            openModalForDuty(dutyId);
        });
    });

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    // Close when clicking outside the modal card
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
});
</script>
</body>
</html>