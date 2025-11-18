<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - @yield('title', 'Dashboard')</title>
    <style>
        /* SEMUA CSS KONSISTEN DARI ADMIN LAYOUT */
        body { 
            margin: 0; 
            min-height: 100vh;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial; 
            background: #f0f9f9; 
            padding: 1.5rem;
        }
        .topbar { 
            background: #2A857D; 
            color: #fff; 
            padding: 1.5rem 2.5rem;
            display: flex; 
            align-items: center; 
            justify-content: space-between;
            margin-bottom: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .brand { font-weight: 900; letter-spacing: 1px; font-size: 1.5rem; }
        .nav { display: flex; gap: 2rem; align-items: center; justify-content: space-between; width: 100%; }
        .nav-right { display: flex; align-items: center; gap: 2rem; margin-left: auto; }
        .nav a { color: #fff; text-decoration: none; font-weight: 700; font-size: 1rem; }
        .wrap { display: flex; min-height: calc(100vh - 130px); gap: 1.5rem; }
        .sidebar { 
            width: 180px; min-width: 180px; background: #2A857D;
            padding: 1.5rem; display: flex; align-items: center;
            border-radius: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .side-menu { width: 100%; }
        .side-btn { 
            display: flex; align-items: center; justify-content: flex-start;
            width: 100%; background: #1D665F;
            color: #fff; padding: 0.8rem 1.2rem; font-size: 0.9rem;
            font-weight: 500; margin-bottom: 0.8rem; text-decoration: none;
            border: none; transition: all 0.3s ease; border-radius: 50px;
            cursor: pointer; white-space: nowrap;
        }
        .side-btn:hover { background: #165751; transform: translateX(5px); }
        .side-btn.active { /* Class aktif ditambahkan secara dinamis */
            background: #165751;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            font-weight: 700;
        }
        .content { 
            flex: 1; display: flex; flex-direction: column; 
            align-items: center; justify-content: center; background: #2A857D;
            border-radius: 15px; margin: 0 auto; padding: 2.5rem; width: 100%;
            min-height: calc(100vh - 150px); box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative; overflow: hidden;
        }
        .logout { background: transparent; color: #fff; border: 2px solid #fff; padding: .45rem .7rem; border-radius: 5px; font-weight: 600; cursor: pointer; }

        /* Utility/Form Styles */
        .content-overlay {
            position: absolute; top: 20px; left: 20px; right: 20px; 
            max-height: calc(100% - 40px); overflow-y: auto; background: white; 
            border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,.2);
            padding: 1.5rem; z-index: 10; width: auto; max-width: none;
        }
        .logo-placeholder { max-width: 300px; width: 100%; height: auto; filter: brightness(1.1); opacity: 0.6; }
        .alert-session { margin:.6rem 0; padding:.6rem; background:#ecfeff; border:1px solid #06b6d4; border-radius:8px;} 
        
        /* Table Styles */
        table { width:100%; border-collapse:collapse; margin-top:1rem; }
        th, td { padding:.55rem .7rem; border-bottom:1px solid #e5e7eb; text-align:left; font-size:.9rem; }
        th { background:#e5f3f3; font-weight:800; }
        .table-btn { background:#1f2937; color:#fff; padding:.4rem .7rem; border-radius:6px; text-decoration:none; border:none; cursor:pointer; font-size:.8rem; margin-right: 0.3rem; }
        
        /* Badge */
        .badge { padding:.25rem .5rem; border-radius:6px; font-size:.8rem; font-weight:600; }
        .badge-aktif { background:#d1fae5; color:#065f46; }
        .badge-selesai { background:#fee2e2; color:#991b1b; }
        .badge-ditunda { background:#dbeafe; color:#1e40af; } /* Menambah status ditunda */
        
        /* Form Card Styles */
        .content-card {
            width: 100%;
            max-width: 550px;
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: auto; /* Tengah horizontal */
            z-index: 10;
            position: relative; /* Agar di atas logo-placeholder */
            max-height: calc(100% - 40px); /* Agar bisa di-scroll jika form panjang */
            overflow-y: auto;
        }
        label { display:block; font-weight:700; margin:.6rem 0 .3rem; }
        select, input, textarea { width:100%; padding:.55rem .7rem; border:1px solid #d1d5db; border-radius:8px; box-sizing: border-box; }
        .row { display:flex; gap:1rem; }
        .row > div { flex: 1; } /* Agar input di .row sama lebar */
        .form-actions { display: flex; gap: 0.5rem; margin-top: 1.5rem; }
        .btn-submit { background-color: #2A857D; color: white; padding: 0.6rem 1rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
        .btn-cancel { background-color: #6c757d; color: white; padding: 0.6rem 1rem; border-radius: 8px; text-decoration: none; }
    </style>
    @yield('styles')
</head>
<body>
    @php
        // Logika untuk menentukan route HOME berdasarkan peran
        $homeRoute = route('dashboard'); // Fallback default
        if (auth()->check()) {
            $role = auth()->user()->role;
            if ($role === 'admin') {
                $homeRoute = route('admin.dashboard');
            } elseif ($role === 'tenaga_medis' || $role === 'nakes') {
                $homeRoute = route('medis.dashboard');
            }
        }
    @endphp

    <div class="topbar">
        <div class="nav">
            <div class="brand">HEALTH SYNC</div>
            <div class="nav-right">
                <a href="{{ $homeRoute }}">HOME</a>
            </div>
        </div>
    </div>

    <div class="wrap">
        <aside class="sidebar" id="sidebar">
            <div class="side-menu">
                
                @if(auth()->user()->role === 'admin')
                    {{-- == LINK SIDEBAR ADMIN == --}}
                    <a class="side-btn @if(request()->routeIs('admin.jadwal.*')) active @endif" href="{{ route('admin.jadwal.home') }}">
                        Jadwal Kegiatan
                    </a>
                    <a class="side-btn @if(request()->routeIs('admin.instruksi.*')) active @endif" href="{{ route('admin.instruksi.index') }}">
                        Instruksi Obat
                    </a>
                
                @elseif(auth()->user()->role === 'tenaga_medis' || auth()->user()->role === 'nakes')
                    {{-- == LINK SIDEBAR TENAGA MEDIS == --}}
                    <a class="side-btn @if(request()->routeIs('medis.riwayat')) active @endif" href="{{ route('medis.riwayat') }}">
                        Riwayat Kondisi
                    </a>
                    <a class="side-btn @if(request()->routeIs('medis.instruksi.*')) active @endif" href="{{ route('medis.instruksi.index') }}">
                        Instruksi Obat
                    </a>
                
                @endif
                
            </div>
        </aside>
        
        <main class="content">
            {{-- Logo placeholder di belakang konten --}}
            <img class="logo-placeholder" src="{{ asset('images/HEALTHSYNC.png') }}" alt="HEALTHSYNC">
            
            {{-- Konten dinamis akan dimuat di sini --}}
            @yield('content')
        </main>
    </div>

    @yield('scripts')
    
    <!-- Service Worker Registration -->
    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", function() {
                navigator.serviceWorker.register("/sw.js")
                    .then(function(registration) {
                        console.log("Service Worker registered successfully:", registration.scope);
                    })
                    .catch(function(error) {
                        console.error("Service Worker registration failed:", error);
                    });
            });
        }
    </script>
    
    <!-- Push Notification Service -->
    <script src="{{ asset('push-notification.js') }}"></script>
</body>
</html>