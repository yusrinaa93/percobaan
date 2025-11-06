<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Course</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="font-family: 'Poppins', sans-serif; background-color: #f3f4f6; margin: 0; padding: 40px 20px; display: flex; justify-content: center; align-items: center; min-height: 100vh; box-sizing: border-box;">

    <div style="background: #fff; padding: 25px 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 450px;">
        <h2 style="text-align: center; margin-bottom: 20px; color: #333;">
            Form Pendaftaran Course
        </h2>
        
        {{-- Menggunakan helper route() dan @csrf --}}
        <form id="registrationForm" action="{{ route('course.register.store') }}" method="POST">
            @csrf
            {{-- Pilih Course --}}
            <div style="margin-bottom: 15px;">
                <label for="course_id" style="display:block; margin-bottom:5px; color:#444; font-size:14px;">Pilih Pelatihan</label>
                <select id="course_id" name="course_id" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:14px; box-sizing:border-box;">
                    <option value="" disabled {{ empty($selected_course_id) ? 'selected' : '' }}>-- pilih --</option>
                    @foreach(($courses ?? []) as $course)
                        <option value="{{ $course->id }}" {{ (isset($selected_course_id) && $selected_course_id == $course->id) ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Field Nama Lengkap (Bisa Diedit) --}}
            <div style="margin-bottom: 15px;">
                <label for="nama" style="display:block; margin-bottom:5px; color:#444; font-size:14px;">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="nama" 
                    name="nama" 
                    value="{{ $user->name ?? '' }}" 
                    required
                    style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:14px; box-sizing:border-box;">
            </div>

            {{-- Field Email (Tidak Bisa Diedit) --}}
            <div style="margin-bottom: 15px;">
                <label for="email" style="display:block; margin-bottom:5px; color:#444; font-size:14px;">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ $user->email ?? '' }}" 
                    readonly 
                    style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:14px; box-sizing:border-box; background-color: #e9ecef; cursor: not-allowed;">
            </div>

            {{-- Field lain yang harus diisi manual --}}
            <div style="margin-bottom: 15px;">
                <label for="tempat_lahir" style="display:block; margin-bottom:5px; color:#444; font-size:14px;">Tempat Lahir</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:14px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="tanggal_lahir" style="display:block; margin-bottom:5px; color:#444; font-size:14px;">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:14px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="nomor_wa" style="display:block; margin-bottom:5px; color:#444; font-size:14px;">Nomor WhatsApp</label>
                <input type="text" id="nomor_wa" name="nomor_wa" placeholder="+62..." required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:14px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="alamat" style="display:block; margin-bottom:5px; color:#444; font-size:14px;">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:14px; box-sizing:border-box;"></textarea>
            </div>
            <button type="submit" style="width:100%; padding:12px; background-color:#00a884; color:white; border:none; border-radius:6px; cursor:pointer; font-size:16px; font-weight: 600; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#009070'" onmouseout="this.style.backgroundColor='#00a884'">
                Daftar Sekarang
            </button>
        </form>
    </div>

    {{-- Kode JavaScript tidak perlu diubah sama sekali --}}
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const actionUrl = this.getAttribute('action');
            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            })
            .then(response => {
                if (response.status === 422 || response.status === 500) {
                    return response.json().then(data => {
                        const error = new Error(data.message || 'Terjadi error.');
                        error.response = data;
                        throw error;
                    });
                }
                if (!response.ok) { throw new Error('Network response was not ok.'); }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pendaftaran Berhasil!',
                        text: 'Selamat! Anda telah terdaftar pada kursus ini.',
                        confirmButtonText: 'Lanjutkan ke Halaman My Course',
                        confirmButtonColor: '#00a884'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/my-courses'; 
                        }
                    });
                }
            })
            .catch(error => {
                let title = 'Terjadi Error!';
                let htmlContent = 'Silakan coba beberapa saat lagi.';
                if (error.response && error.response.errors) {
                    title = 'Data Tidak Valid!';
                    htmlContent = '<ul style="text-align:left; list-style-position:inside;">' +
                        Object.values(error.response.errors).map(e => `<li>${e[0]}</li>`).join('') +
                        '</ul>';
                } else if (error.response) {
                    htmlContent = error.response.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: title,
                    html: htmlContent,
                });
                console.error("Error:", error);
            });
        });
    </script>

</body>
</html>