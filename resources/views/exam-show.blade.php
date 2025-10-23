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
    {{-- CSS TAMBAHAN (Letakkan di style.css Anda) --}}
    <style>
        .exam-list-card h3 { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .exam-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #f0f0f0; }
        .exam-item:last-child { border-bottom: none; }
        .exam-details h4 { margin: 0 0 5px 0; font-size: 1.1rem; }
        .exam-details p { margin: 0 0 5px 0; font-size: 0.9rem; color: #666; }
        .exam-details .question-count { font-size: 0.8rem; color: #888; font-weight: 500; }
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

        {{-- INI BAGIAN YANG DIROMBAK TOTAL --}}
        <section class="content-section">
            {{-- Controller mengirim $exam (tunggal) --}}
            <h2>UJIAN: {{ $exam->title }}</h2>
            <div class="content-card exam-card">
                
                {{-- Form untuk mengirim jawaban ke route 'exams.submit' --}}
                <form action="{{ route('exams.submit', $exam->id) }}" method="POST">
                    @csrf
                    
                    @foreach($exam->questions as $index => $question)
                        <div class="question-block">
                            <h4>{{ $index + 1 }}. {{ $question->question_text }}</h4>
                            
                            <div class="options-block">
                                @foreach($question->options as $option)
                                    <div class="option-item">
                                        {{-- 
                                          Nama 'answers[QUESTION_ID]' dan value 'OPTION_ID' 
                                          sangat penting untuk proses penilaian di Controller
                                        --}}
                                        <input type="radio" 
                                               name="answers[{{ $question->id }}]" 
                                               value="{{ $option->id }}" 
                                               id="option-{{ $option->id }}"
                                               required>
                                        <label for="option-{{ $option->id }}">{{ $option->option_text }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="row center" style="margin-top: 30px;">
                        <button type="submit" class="btn btn-start">Kumpulkan Jawaban</button>
                    </div>

                </form>
            </div>
        </section>
        {{-- AKHIR BAGIAN YANG DIROMBAK --}}

    </main>
</div>

{{-- JavaScript Anda (Tidak diubah) --}}
<script>
    // ... (Semua JS Anda persis seperti sebelumnya) ...
</script>
</body>
</html>