<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; background:#ffffff; margin:0; }
        .frame { max-width: 360px; margin: 2rem auto; border: 2px solid #2563eb; padding: 0; background:#fff; }
        .header { background:#0f766e; color:#ffffff; text-align:center; padding:.6rem 1rem; font-weight:800; letter-spacing:.8px; }
        .content { padding: 1.25rem; }
        h1 { margin: .25rem 0 1rem; font-size: 1.25rem; text-align:center; letter-spacing:.5px; }
        .field { margin-bottom: .9rem; }
        .label { display:block; font-size:.72rem; font-weight:800; letter-spacing:.6px; margin-bottom:.35rem; color:#111827; text-transform:uppercase; }
        .control { width:100%; padding:.55rem .65rem; border: 0; background:#e5e7eb; border-radius:2px; font-size:.95rem; }
        .error { color:#b91c1c; font-size:.82rem; margin:.4rem 0; }
        .actions { margin-top:.6rem; }
        .btn-primary { width:100%; background:#2563eb; color:#fff; border:0; padding:.55rem 1rem; border-radius:2px; font-weight:800; cursor:pointer; }
        .btn-primary:hover { background:#1d4ed8; }
        .muted { text-align:center; color:#111827; font-size:.8rem; margin-top:.6rem; }
        .muted a { color:#2563eb; text-decoration:underline; }
    </style>
    <script>
        // Tambah proteksi submit ganda sederhana
        document.addEventListener('DOMContentLoaded', function(){
            const form = document.getElementById('login-form');
            if (!form) return;
            form.addEventListener('submit', function(){
                const btn = form.querySelector('button[type="submit"]');
                if (btn) { btn.disabled = true; btn.textContent = 'Memproses...'; }
            });
        });
    </script>
  
    
</head>
<body>
    <div class="frame">
        <div class="header">HEALTH SYNC</div>
        <div class="content">
        <h1>LOG IN</h1>

        @if ($errors->any())
            <div class="error" role="alert">{{ $errors->first() }}</div>
        @endif

        <form id="login-form" method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="field">
                <label class="label" for="email">Email</label>
                <input class="control" id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label class="label" for="password">Password</label>
                <input class="control" id="password" name="password" type="password" required autocomplete="current-password">
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="actions">
                <button class="btn-primary" type="submit">LOGIN</button>
            </div>
        </form>
    </div>
</body>
</html>


