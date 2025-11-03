<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial; background:#f9fafb; margin:0; }
        .wrap { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
        .card { background:#fff; border-radius:12px; box-shadow: 0 8px 24px rgba(0,0,0,.06); padding:1.5rem; }
        .row { display:flex; align-items:center; justify-content:space-between; gap:1rem; }
        form { margin:0; }
        button { background:#111827; color:#fff; border:none; padding:.6rem .9rem; border-radius:8px; cursor:pointer; font-weight:600; }
        button:hover { background:#0b1220; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="row">
                <h1 style="margin:0;">Halo, {{ auth()->user()->name ?? auth()->user()->email }}</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            </div>
            <p style="color:#6b7280;">Anda berhasil login.</p>
        </div>
    </div>
</body>
</html>


