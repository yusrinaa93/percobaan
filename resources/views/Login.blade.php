<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pelatihan Halal</title>
    {{-- Menggunakan helper asset() Blade --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .error-message { color: #D8000C; background-color: #FFD2D2; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 0.9em; }
    </style>
</head>
<body class="form-page">
    <div class="form-container">
        <div class="form-image-panel"></div>
        <div class="form-content-panel">
            <nav class="form-nav">
                <ul>
                    {{-- Menggunakan helper route() untuk link --}}
                    <li><a href="/">HOME</a></li>
                    <li><a href="{{ route('courses') }}">COURSES</a></li>
                    <li><a href="/about">ABOUT</a></li>
                    <li><a href="{{ route('login') }}" class="active">LOGIN</a></li>
                </ul>
            </nav>
            <div class="form-wrapper">
                <h1 class="form-title">LOGIN</h1>

                {{-- Menampilkan pesan sukses dengan sintaks Blade --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Menampilkan error validasi dengan sintaks Blade --}}
                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    {{-- Mengganti input CSRF manual dengan directive Blade --}}
                    @csrf
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        {{-- Menggunakan helper old() Blade untuk mengisi kembali email --}}
                        <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                        <i class="fas fa-eye-slash toggle-password"></i>
                    </div>
                    <button type="submit" class="submit-button">LOGIN</button>
                </form>
                <p class="form-bottom-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                </p>
            </div>
        </div>
    </div>

{{-- Kode JavaScript tidak perlu diubah --}}
<script>
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const passwordInput = this.previousElementSibling;
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>
</body>
</html>