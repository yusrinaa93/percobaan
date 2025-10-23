<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat</title>
    <style>
        /* Atur halaman PDF */
        @page {
            margin: 0; 
            size: auto;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            font-size: 12pt; 
        }
        .page {
            width: 100%;
            height: 100%;
            position: relative;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .page-break {
            page-break-after: always;
        }

        /* Posisi disesuaikan dengan template sertifikat */
        .nama {
            position: absolute;
            top: 445px;      /* Disesuaikan agar pas dengan label "Nama" */
            left: 410px;     /* Disesuaikan agar rata dengan data */
            font-weight: 600    ;
            font-size: 15pt; /* Sedikit lebih besar untuk nama */
            z-index: 10;
        }
        .ttl {
            position: absolute;
            top: 485px;      /* Di bawah nama, sesuai label "TTL" */
            left: 410px;    
            font-weight: 600    ; /* Sejajar dengan nama */
            font-size: 15pt;
            z-index: 10;
        }
        .no-hp {
            position: absolute;
            top: 525px;      /* Di bawah TTL, sesuai label "No HP" */
            left: 410px;     /* Sejajar dengan nama dan TTL */
            font-weight: 600    ; /* Sejajar dengan nama */
            font-size: 15pt;
            z-index: 10;
        }
        
    </style>
</head>
<body>
    
    <div class="page page-break">
        
        <img src="{{ asset('gambar/template-halaman-1.png') }}" class="background" alt="">

        {{-- Data dinamis dari controller/database --}}
        <div class="nama">{{ $nama }}</div>
        <div class="ttl">{{ $tempat_tanggal_lahir }}</div>
        <div class="no-hp">{{ $no_hp }}</div>
    
    </div>

    <div class="page">
        
        <img src="{{ asset('gambar/template-halaman-2.png') }}" class="background" alt="">

    </div>

</body>
</html>