<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Pelatihan Penyelia Halal</title>
    {{-- Mengganti <?php echo asset(...); ?> dengan sintaks Blade --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo Halal">
            <div class="logo-text">
                <span>Pelatihan</span>
                <span>Pendamping Penyelia Halal</span>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="/">HOME</a></li>
                <li><a href="/courses">COURSES</a></li>
                <li><a href="/about" class="active">ABOUT</a></li>
                
                @if (Auth::check())
                    <li class="profile-dropdown">
                        <div class="profile-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li>
                                {{-- Menggunakan helper route() dan @csrf --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li><a href="/login">LOGIN</a></li>
                @endif
            </ul>
        </nav>
    </header>

    <main class="page-container">
        <div class="content-card">
            <h1 class="card-title">About</h1>
            <div class="about-content">
                <div class="about-logo">
                    <img src="{{ asset('gambar/logo halal center.png') }}" alt="Logo LP3H">
                </div>
                <div class="about-text">
                    <h3>Lembaga Pendamping Proses Produk Halal (LP3H)</h3>
                    <p>
                        LP3H (Lembaga Pendamping Proses Produk Halal) UIN Sunan Kalijaga Yogyakarta merupakan Lembaga yang dibentuk dan tersertifikasi oleh BPJPH (Badan Penyelenggara Jaminan Produk Halal) Kementerian Agama Republik Indonesia. LP3H UIN Sunan Kalijaga Yogyakarta lahir pada 17 November 2021 secara sah dengan Nomor Registrasi 2112200002 dari unsur Perguruan Tinggi. LP3H UIN Sunan Kalijaga Yogyakarta merupakan Lembaga Pendamping pertama di Indonesia dengan beberapa LP3H lain dari unsur PTKIN (Perguruan Tinggi Keagamaan Islam Negeri) seperti UIN Syarif Hidayatullah Jakarta, UIN Sunan Gunung Djati Bandung, UIN Walisongo Semarang, UIN Maulana Malik Ibrahim Malang, dan UIN Sunan Ampel Surabaya.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-bottom">
            <p>© 2025 Pelatihan Penyelia Halal. All Rights Reserved.</p>
        </div>
    </footer>

    {{-- Kode JavaScript tidak perlu diubah sama sekali --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
    </script>
</body>
</html>