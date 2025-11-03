<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Riwayat Kondisi Lansia</title>
    <style>
        body { margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial; background:#ffffff; }
        .topbar { background:#1f8a8a; color:#fff; padding:.6rem 1rem; border:3px solid #0f172a; display:flex; align-items:center; justify-content:space-between; }
        .brand { font-weight:900; letter-spacing:.8px; font-size:1.35rem; }
        .nav { display:flex; gap:1.25rem; align-items:center; }
        .nav a { color:#fff; text-decoration:none; font-weight:700; font-size:.9rem; }
        .wrap { display:flex; }
        .sidebar { width:220px; min-height: calc(100vh - 52px); background:#247e81; padding: .75rem; border-right: 2px solid #0f172a; }
        .side-btn { display:block; width:100%; background:#fff; color:#111827; padding:.55rem .7rem; border-radius:18px; font-weight:800; margin:.7rem 0; text-align:left; border:2px solid #0f172a; box-shadow:0 2px 0 rgba(0,0,0,.2); }
        .side-btn.active { background:#e5f3f3; }
        .content { flex:1; padding:1.25rem; }
        .panel { background:#f9fafb; border: 2px solid #d1d5db; border-radius:10px; box-shadow: 0 2px 6px rgba(0,0,0,.08) inset; padding:1rem; }
        .title { font-weight:900; letter-spacing:.6px; margin: .25rem 0 1rem; }
        .label { display:block; font-size:.72rem; font-weight:800; letter-spacing:.6px; margin-bottom:.35rem; color:#111827; }
        .select { width:260px; padding:.45rem .6rem; background:#1f7f83; color:#fff; border:2px solid #0f172a; border-radius:18px; }
        .box { margin-top:1rem; background:#1f7f83; min-height:140px; border-radius:18px; border:2px solid #0f172a; box-shadow:0 2px 0 rgba(0,0,0,.3); }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="brand">HEALTH SYNC</div>
        <div class="nav">
            <a href="{{ route('medis.dashboard') }}">HOME</a>
            <a href="#">NOTIFIKASI</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button style="background:#0f172a;color:#fff;border:none;padding:.4rem .6rem;border-radius:18px;font-weight:800;cursor:pointer;" type="submit">Keluar</button>
            </form>
        </div>
    </div>

    <div class="wrap">
        <aside class="sidebar">
            <a class="side-btn active" href="{{ route('medis.riwayat') }}">Riwayat Kondisi Lansia</a>
            <a class="side-btn" href="{{ route('medis.dashboard') }}">Instruksi Obat</a>
        </aside>
        <main class="content">
            <div class="panel">
                <div class="title">RIWAYAT KONDISI LANSIA</div>
                <label class="label">NAMA LANSIA (username)</label>
                <select class="select">
                    @foreach ($lansiaList as $l)
                        <option value="{{ $l['username'] }}">{{ $l['nama'] }} ({{ $l['username'] }})</option>
                    @endforeach
                </select>

                <div class="box"></div>
            </div>
        </main>
    </div>
</body>
</html>


