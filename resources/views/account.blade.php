<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Pelatihan Halal</title>
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
                <li><a href="{{ route('courses') }}"><i class="fas fa-graduation-cap"></i><span>Courses</span></a></li>
                <li class="has-submenu">
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
            <a href="{{ route('account') }}" class="active"><i class="fas fa-user-circle"></i><span>Account</span></a>
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
            <h2>ACCOUNT</h2>
            <div class="account-card">
                <aside class="profile-sidebar">
                    {{-- Ganti dengan path avatar user jika ada, atau biarkan placeholder --}}
                    <img src="https://via.placeholder.com/100" alt="Avatar Pengguna" class="profile-avatar">
                    
                    {{-- Mengambil nama user yang sedang login --}}
                    <h3>{{ Auth::user()->name }}</h3>
                    
                    <button class="btn btn-upload"><i class="fas fa-camera"></i><span>Upload Picture</span></button>
                </aside>
                <section class="profile-details">
                    <h3>Profile</h3>
                    <p>This information can be edited.</p>
                    
                    {{-- Form untuk update profil --}}
                    <form action="{{ route('account') }}" method="POST">
                        @csrf {{-- Menambahkan token keamanan --}}
                        @method('PATCH') {{-- Metode untuk update, bisa juga 'PUT' --}}

                        <div class="profile-form-grid">
                            <div class="form-group">
                                <label for="name">Full Name :</label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address :</label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                            </div>
                            {{-- Tambahkan field lain sesuai kebutuhan --}}
                            <div class="form-group">
                                <label for="current_password">Current Password :</label>
                                <input type="password" id="current_password" name="current_password" placeholder="Enter current password to update">
                            </div>
                             <div class="form-group">
                                <label for="new_password">New Password :</label>
                                <input type="password" id="new_password" name="new_password" placeholder="Enter new password">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-update">UPDATE</button>
                        </div>
                    </form>
                </section>
            </div>
        </section>
    </main>
</div>

<script>
    // Kode JS asli Anda tidak perlu diubah
</script>
</body>
</html>