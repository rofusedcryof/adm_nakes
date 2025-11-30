<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Sync</title>
    <style>
        body { font-family: Arial, sans-serif; margin:0; background:#eaeef2; display:flex; justify-content:center; }
        .phone { width:360px; max-width:100%; min-height:100vh; background:#f7f9fb; box-shadow:0 8px 24px rgba(0,0,0,0.12); }
        .topbar { background:#0d6b6b; color:#fff; padding:16px; display:flex; align-items:center; justify-content:center; }
        .brand { font-weight:800; letter-spacing:1.5px; font-size:18px; }
        .container { padding:16px; }
        .section-title { font-size:12px; color:#6b7280; margin-bottom:8px; letter-spacing:.5px; }
        .card { background:#fff; border-radius:14px; padding:14px; margin-bottom:16px; box-shadow:0 2px 8px rgba(0,0,0,0.08); position:relative; }
        .add-btn { position:absolute; top:10px; right:10px; width:30px; height:30px; border-radius:8px; border:1px solid #cbd5e1; display:flex; align-items:center; justify-content:center; background:#f1f5f9; color:#0d6b6b; text-decoration:none; }
        .btn { background:#0d6b6b; color:#fff; border:none; border-radius:10px; padding:10px 14px; cursor:pointer; }
        .list { list-style:none; padding:0; margin:0; }
        .list li { padding:8px 0; border-bottom:1px solid #eee; }
        .grid { display:grid; grid-template-columns: repeat(2, 1fr); gap:8px; }
        .bottom-nav { position:fixed; bottom:0; left:0; right:0; background:#fff; display:flex; justify-content:space-around; align-items:center; padding:12px 0; box-shadow:0 -2px 8px rgba(0,0,0,0.1); }
        .nav-item { display:flex; flex-direction:column; align-items:center; text-decoration:none; color:#000; flex:1; }
        .nav-item.active { color:#2A857D; }
        .nav-icon { width:24px; height:24px; margin-bottom:4px; }
        .icon-home { display:inline-block; width:24px; height:24px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%232A857D'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'/%3E%3C/svg%3E"); background-size:contain; }
        .icon-bell { display:inline-block; width:24px; height:24px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'/%3E%3C/svg%3E"); background-size:contain; }
        .icon-profile { display:inline-block; width:24px; height:24px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23000'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E"); background-size:contain; }
        select, input { width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; }
    </style>
</head>
<body>
    <div class="phone">
        <div class="topbar">
            <div class="brand">HEALTH SYNC</div>
        </div>
        <div class="container">
            @yield('content')
        </div>
        <div class="bottom-nav">
            <a href="{{ route('keluarga.dashboard') }}" class="nav-item active">
                <span class="icon-home nav-icon"></span>
                <span style="font-size:12px;">Home</span>
            </a>
            <a href="{{ route('keluarga.notifikasi') }}" class="nav-item">
                <span class="icon-bell nav-icon"></span>
                <span style="font-size:12px;">Notifikasi</span>
            </a>
            <a href="{{ route('keluarga.profil') }}" class="nav-item">
                <span class="icon-profile nav-icon"></span>
                <span style="font-size:12px;">Profil</span>
            </a>
        </div>
    </div>
</body>
</html>
