<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Welcome</title>
    <style>
        /* CSS Umum dan Reset */
        body { 
            margin: 0; 
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial; 
            background: #f0f9f9; 
            display: flex; 
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 0; 
            box-sizing: border-box;
            overflow: hidden; 
            position: relative;
        }

        /* CONTAINER UTAMA (Wrapper Putih) */
        .main-wrapper {
            width: 90%; 
            max-width: 1200px; 
            height: 80vh; 
            max-height: 650px; 
            background: #fff; 
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            position: relative; 
            display: flex; 
            align-items: center;
            overflow: hidden; 
        }

        /* GAMBAR LANSIA SEBAGAI BACKGROUND */
        .main-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Menggunakan gambar Lansia.png (asumsi ini adalah gambar lansia yang sedang menari) */
            background: url('{{ asset('images/Lansia.png') }}') no-repeat;
            background-size: 50%; /* Ukuran sedang untuk perawat/lansia */
            background-position: right center; /* Posisi menempel di kanan tengah */
            z-index: 1; 
        }
        
        /* CARD KONTEN KIRI (HIJAU TUA) */
        .content-card {
            background: #2A857D; 
            width: 450px; 
            height: 85%; 
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); 
            display: flex;
            flex-direction: column;
            justify-content: space-around; 
            align-items: center;
            padding: 2.5rem 2rem; 
            box-sizing: border-box;
            position: absolute;
            left: 5%; 
            top: 50%;
            transform: translate(0, -50%); 
            z-index: 10; 
        }
        
        /* LOGO DI CARD KIRI */
        .app-logo {
            max-width: 75%; 
            width: 100%;
            height: auto;
            filter: brightness(1.2); 
            opacity: 0.9;
            margin-top: -1rem; 
        }

        /* SLOGAN DI ATAS GAMBAR LANSIA (KANAN) */
        .slogan-overlay {
            position: absolute;
            top: 10%; /* Jarak dari atas */
            right: 10%; /* Jarak dari kanan */
            width: 40%; 
            color: #2A857D; /* Warna teks hijau tua */
            text-align: right;
            font-weight: 800;
            font-size: 1.5rem;
            line-height: 1.2;
            z-index: 5;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan agar terlihat dari background */
        }
        
        /* CONTAINER UNTUK TOMBOL */
        .nav-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem; 
            justify-content: center;
            width: 100%;
            margin-bottom: 1rem; 
        }
        .nav-button {
            background: #1D665F; 
            color: #fff;
            padding: 1rem 0.8rem; 
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem; 
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            white-space: nowrap; 
            flex: 1 1 45%;
            text-align: center;
            border: none;
            cursor: pointer;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }
        .nav-button:hover {
            background: #165751;
            transform: translateY(-3px);
        }
        .nav-button-form {
            flex: 1 1 45%;
            margin: 0;
        }


    </style>
</head>
<body>
    <div class="main-wrapper">
        
        <div class="content-card">
            
            <img class="app-logo" src="{{ asset('images/HEALTHSYNC.png') }}" alt="HEALTHSYNC ELDERLY MONITORING">

            <div class="nav-buttons">
                <a class="nav-button" href="{{ route('admin.jadwal.home') }}">
                    Jadwal Kegiatan
                </a>
                <a class="nav-button" href="{{ route('admin.instruksi.index') }}">
                    Instruksi Obat
                </a>
                <form class="nav-button-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-button nav-button--logout">
                        Logout
                    </button>
                </form>
                
            </div>
        </div>

        {{-- SLOGAN DI ATAS GAMBAR LANSIA --}}
        <div class="slogan-overlay">
            Caring with heart, united in Wellness
        </div>
        
    </div>
</body>
</html>