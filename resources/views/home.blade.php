<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelatihan Pendamping Penyelia Halal</title>
    {{-- Menggunakan helper asset() Blade --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body class="home-page">

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
                {{-- Menggunakan helper route() untuk link yang lebih baik --}}
                <li><a href="/" class="active">HOME</a></li>
                <li><a href="{{ route('courses') }}">COURSES</a></li>
                <li><a href="/about">ABOUT</a></li>
                
                {{-- Mengganti sintaks PHP if/else dengan @auth --}}
                @auth
                    <li class="profile-dropdown">
                        <div class="profile-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <ul class="dropdown-menu">
                            <li>
                                {{-- Form Logout dengan @csrf --}}
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

    <main class="hero">
        <div class="hero-content">
            <h1>Pelatihan PPH - Batch 1</h1>
            <p>Ini adalah deskripsi mengenai pelatihan PPH pada dengan Desmber tanggal 21.<br>Pelatihan ini bersifat online.</p>
            <a href="{{ route('courses') }}" class="cta-button">START COURSE</a>
        </div>
    </main>

    <section class="contact-page">
        <div class="container">
            <div class="contact-info-cards">
                <div class="info-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Address</h3>
                    <p>Papringan, Caturtunggal, Depok, Sleman, DIY 55281</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-phone-alt"></i>
                    <h3>Contact</h3>
                    <p>(0274) 123-4567</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-envelope"></i>
                    <h3>Email</h3>
                    <p>kontak@pelatihanhalal.com</p>
                </div>
            </div>
            <div class="contact-main-content">
                <div class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.153922633913!2d110.4085446152796!3d-7.773539094396001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a599a2c3a0b8f%3A0x2ed9b2e91a33a57!2sUIN%20Sunan%20Kalijaga%20Yogyakarta!5e0!3m2!1sen!2sid!4v1672833139363!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <form class="contact-form-detailed" action="#" method="post">
                    {{-- Jika form ini akan digunakan, tambahkan @csrf di sini --}}
                    <div class="form-group">
                        <label for="name">Your Name *</label>
                        <input type="text" id="name" name="name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <label for="message">Description *</label>
                        <textarea id="message" name="message" rows="4" placeholder="Message" required></textarea>
                    </div>
                    <button type="submit" class="cta-button form-button">Send</button>
                </form>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="footer-bottom">
            <p>© 2025 Pelatihan Penyelia Halal. All Rights Reserved.</p>
        </div>
    </footer>

    {{-- Kode JavaScript tidak perlu diubah sama sekali --}}
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