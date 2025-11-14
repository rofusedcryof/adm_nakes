<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HEALTH SYNC - Admin')</title>
    <style>
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
        .brand { 
            font-weight: 900; 
            letter-spacing: 1px; 
            font-size: 1.5rem; 
        }
        .nav { 
            display: flex; 
            gap: 2rem; 
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-left: auto;
        }
        .nav a { 
            color: #fff; 
            text-decoration: none; 
            font-weight: 700; 
            font-size: 1rem; 
        }
        .logout { 
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
            padding: .45rem .7rem;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
        }
        .wrap { 
            display: flex; 
            min-height: calc(100vh - 130px);
            gap: 1.5rem;
        }
        .sidebar { 
            width: 220px;
            min-width: 220px;
            background: #2A857D;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .side-logo {
            width: 120px;
            margin-bottom: 1.5rem;
        }
        .side-btn { 
            display: block;
            width: 100%;
            background: #1D665F;
            color: #fff;
            padding: 0.8rem 1.2rem;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-decoration: none;
            border: none;
            transition: all 0.3s ease;
            border-radius: 50px;
            text-align: center;
        }
        .side-btn:hover {
            background: #165751;
            transform: translateX(5px);
        }
        .content { 
            flex: 1;
            background: #2A857D;
            border-radius: 15px;
            padding: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            .wrap {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="nav">
            <div class="brand">HEALTH SYNC</div>
            <div class="nav-right">
                <a href="{{ route('admin.dashboard') }}">HOME</a>
                <a href="#">NOTIFIKASI</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout" type="submit">Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="wrap">
        <aside class="sidebar">
            <img src="{{ asset('images/healthsync-logo.png') }}" alt="Logo" class="side-logo">
            <a class="side-btn" href="{{ route('admin.jadwal.index') }}">Jadwal Kegiatan</a>
            <a class="side-btn" href="{{ route('admin.instruksi.index') }}">Instruksi Obat</a>
        </aside>

        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
