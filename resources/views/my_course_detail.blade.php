<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Pelatihan - {{ $course->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; }
        .tabs { gap: 24px; border-bottom: 1px solid #e5e7eb; }
        .tabs .tab-link { color: #111827; text-decoration: none; font-weight: 600; padding: 14px 0; display: inline-block; border-bottom: 3px solid transparent; }
        .tabs .tab-link:hover { color: #059669; }
        .tabs .tab-link.active { color: #059669; border-color: #10b981; }
        .tab-panels table { width: 100%; border-collapse: collapse; }
        .tab-panels th, .tab-panels td { padding: 12px 16px; border-bottom: 1px solid #eef2f7; }
        .btn-start { background:#10b981; color:#fff; padding:8px 16px; border-radius:20px; text-decoration:none; font-weight:600; }
        .btn-disabled { background:#d8dee3; color:#888; padding:8px 16px; border-radius:20px; font-weight:600; }
        .btn-download { background:#3b82f6; color:#fff; padding:8px 16px; border-radius:8px; text-decoration:none; font-weight:600; }
        .btn-zoom.btn-small { padding:6px 12px; border-radius:8px; }
    </style>
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
            <h2>Materi Pelatihan</h2>

            <div class="content-card">
                <div class="tabs" style="display:flex;gap:24px;border-bottom:1px solid #e5e7eb;">
                    <a href="#tab-zoom" class="tab-link active" data-tab="tab-zoom">Jadwal & Zoom</a>
                    <a href="#tab-presensi" class="tab-link" data-tab="tab-presensi">Presensi</a>
                    <a href="#tab-tugas" class="tab-link" data-tab="tab-tugas">Tugas</a>
                    <a href="#tab-ujian" class="tab-link" data-tab="tab-ujian">Ujian</a>
                    <a href="#tab-sertifikat" class="tab-link" data-tab="tab-sertifikat">Sertifikat</a>
                </div>

                <div class="tab-panels" style="padding-top:16px;">
                    <div id="tab-zoom" class="tab-panel">
                        <h3>Jadwal Zoom Meeting</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th> <th>DATE</th> <th>TIME</th> <th>CATEGORY</th> <th>ZOOM</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->id }}</td>
                                        <td>{{ $schedule->start_time?->format('l, d F Y') }}</td>
                                        <td>{{ $schedule->start_time?->format('H:i') }} - {{ $schedule->end_time?->format('H:i') }}</td>
                                        <td>{{ $schedule->category }}</td>
                                        <td>@if($schedule->zoom_link)<a href="{{ $schedule->zoom_link }}" target="_blank" class="btn btn-zoom">JOIN ZOOM</a>@endif</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" style="text-align:center;">Belum ada jadwal.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div id="tab-presensi" class="tab-panel" style="display:none;">
                        <h3>Presensi</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th> <th>DATE</th> <th>TIME</th> <th>MATERI</th> <th>TIME PRESENCE</th> <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->id }}</td>
                                        <td>{{ $schedule->start_time?->format('l, d M Y') }}</td>
                                        <td>{{ $schedule->start_time?->format('H:i') }} - {{ $schedule->end_time?->format('H:i') }}</td>
                                        <td>{{ $schedule->category }}</td>
                                        <td>{{ $schedule->start_time?->format('H:i') }} - {{ $schedule->end_time?->format('H:i') }}</td>
                                        <td>
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
                                    <tr><td colspan="6" style="text-align:center;">Belum ada materi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div id="tab-tugas" class="tab-panel" style="display:none;">
                        <h3>Tugas</h3>
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
                                @forelse ($duties as $duty)
                                    <tr>
                                        <td>{{ $duty->id }}</td>
                                        <td>{{ $duty->name }}</td>
                                        <td>{!! $duty->description !!}</td>
                                        <td>{{ $duty->deadline->format('l, d F Y') }}</td>
                                        <td>
                                            @if(!empty($duty->submission) && !empty($duty->submission->file_path))
                                                <div class="action-cell">
                                                    <div class="submission-right">
                                                        <a href="{{ Storage::disk('public')->url($duty->submission->file_path) }}" target="_blank" class="btn btn-zoom btn-small">DOWNLOAD</a>
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
                    <div id="tab-ujian" class="tab-panel" style="display:none;">
                        <h3>Ujian</h3>
                        @forelse($exams as $exam)
                            <div class="exam-item" style="display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #eee;padding:12px 0;">
                                <div class="exam-details">
                                    <strong>{{ $exam->title }}</strong>
                                    <div style="color:#666;font-size:0.9rem;">{{ $exam->description ?? 'Tidak ada deskripsi.' }}</div>
                                    <div style="color:#888;font-size:0.8rem;">{{ $exam->questions_count }} Soal</div>
                                </div>
                                <div>
                                    @if ($exam->is_completed)
                                        <span class="btn-disabled">SELESAI</span>
                                    @else
                                        <a href="{{ route('exams.show', $exam->id) }}" class="btn btn-start">START</a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p>Tidak ada ujian yang tersedia saat ini.</p>
                        @endforelse
                    </div>
                    <div id="tab-sertifikat" class="tab-panel" style="display:none;">
                        <h3>Sertifikat</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>NAMA PELATIHAN</th>
                                    <th>STATUS SERTIFIKAT</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $course->title }}</td>
                                    <td>
                                        @if ($course->is_certificate_active)
                                            <span style="color: green; font-weight: 500;">Tersedia</span>
                                        @else
                                            <span style="color: #888; font-style: italic;">Belum Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('certificate.check', $course->id) }}" class="btn btn-download">Unduh</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
// Tabs simple toggler
document.addEventListener('click', function(e){
    const link = e.target.closest('.tab-link');
    if(!link) return;
    e.preventDefault();
    document.querySelectorAll('.tab-link').forEach(a=>a.classList.remove('active'));
    link.classList.add('active');
    const id = link.dataset.tab;
    document.querySelectorAll('.tab-panel').forEach(p=>p.style.display = 'none');
    const panel = document.getElementById(id);
    if(panel) panel.style.display = '';
    // Persist active tab in URL hash
    if (id) location.hash = id;
});
// On load, restore tab from hash if present
window.addEventListener('DOMContentLoaded', function(){
    const hash = location.hash ? location.hash.substring(1) : null;
    if (!hash) return;
    const targetLink = document.querySelector(`.tab-link[data-tab="${hash}"]`);
    if (targetLink) {
        document.querySelectorAll('.tab-link').forEach(a=>a.classList.remove('active'));
        targetLink.classList.add('active');
        document.querySelectorAll('.tab-panel').forEach(p=>p.style.display = 'none');
        const panel = document.getElementById(hash);
        if(panel) panel.style.display = '';
    }
});
// PRESENSI handler
document.addEventListener('click', function(e){
    const btn = e.target.closest('.btn-presence');
    if(!btn) return;
    e.preventDefault();
    const scheduleId = btn.getAttribute('data-schedule-id');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch("{{ route('presence.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ schedule_id: scheduleId })
    }).then(res => {
        if(!res.ok) throw new Error('Server error');
        return res.json();
    }).then(data => {
        if(data.status === 'success'){
            btn.outerHTML = '<button class="btn btn-info" disabled><i class="fas fa-check-circle"></i> SUDAH PRESENSI</button>';
        } else {
            alert(data.message || 'Gagal presensi');
        }
    }).catch(err => {
        console.error(err);
        alert('Tidak dapat terhubung ke server.');
    });
});
// Profile dropdown toggle
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

<!-- Upload Modal (reuse from duty page) -->
<div class="modal-backdrop" id="uploadModal" style="display:none;">
    <div class="modal-card" role="dialog" aria-modal="true">
        <button class="modal-close" id="modalClose">&times;</button>
        <h3>Upload Tugas</h3>
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
    const closeBtn = document.getElementById('modalClose');
    const cancelBtn = document.getElementById('modalCancel');
    const uploadForm = document.getElementById('uploadForm');
    document.querySelectorAll('.open-upload').forEach(btn => {
        btn.addEventListener('click', () => {
            const dutyId = btn.getAttribute('data-duty-id');
            uploadForm.action = `/duty/${dutyId}/upload`;
            modal.style.display = 'flex';
        });
    });
    function closeModal(){ modal.style.display='none'; const i = uploadForm.querySelector('input[type=file]'); if(i) i.value=''; }
    if(closeBtn) closeBtn.addEventListener('click', closeModal);
    if(cancelBtn) cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e)=>{ if(e.target===modal) closeModal(); });
});
</script>
</body>
</html>
