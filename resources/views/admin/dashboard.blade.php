<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Admin</title>
    <style>
        body { margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial; background:#ffffff; }
        .topbar { background:#1f8a8a; color:#fff; padding:.6rem 1rem; border:3px solid #0f172a; display:flex; align-items:center; justify-content:space-between; }
        .brand { font-weight:900; letter-spacing:.8px; font-size:1.35rem; }
        .nav { display:flex; gap:1.25rem; align-items:center; }
        .nav a { color:#fff; text-decoration:none; font-weight:700; font-size:.9rem; }
        .wrap { display:flex; }
        .sidebar { width:220px; min-height: calc(100vh - 52px); background:#247e81; padding: .75rem; border-right: 2px solid #0f172a; }
        .side-btn { display:block; width:100%; background:#fff; color:#111827; padding:.55rem .7rem; border-radius:18px; font-weight:800; margin:.7rem 0; text-align:left; border:2px solid #0f172a; box-shadow:0 2px 0 rgba(0,0,0,.2); }
        .content { flex:1; display:flex; align-items:center; justify-content:center; padding:2rem; }
        .logo { max-width:520px; width:80%; opacity:.9; }
        .logout { background:#0f172a; color:#fff; border:none; padding:.45rem .7rem; border-radius:18px; font-weight:800; cursor:pointer; }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="brand">HEALTH SYNC</div>
        <div class="nav">
            <a href="{{ route('admin.dashboard') }}">HOME</a>
            <a href="#">NOTIFIKASI</a>
            <form class="footer" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout" type="submit">Keluar</button>
            </form>
        </div>
    </div>

    <div class="wrap">
        <aside class="sidebar">
            <a class="side-btn" href="#">Create Jadwal</a>
            <a class="side-btn" href="#">Detele Jadwal</a>
            <a class="side-btn" href="">Read Jadwal</a>
            <a class="side-btn" href="">Update Jadwal</a>
        </aside>
        <main class="content">
            <img class="logo" src="https://dummyimage.com/800x600/e5f3f3/9fbcbc&text=HEALTHSYNC+\nELDERLY+MONITORING" alt="HEALTHSYNC">
        </main>
    </div>
</body>
</html>


