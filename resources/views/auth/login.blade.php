<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* ===== GLOBAL RESET ===== */
        * {
            box-sizing: border-box;
            font-family: 'Poppins', system-ui, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #2A857D, #1B4E47);
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            overflow: hidden;
        }

        /* ===== BACKGROUND ANIMATION ===== */
        .bg-circles::before,
        .bg-circles::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: float 8s ease-in-out infinite alternate;
        }

        .bg-circles::before {
            width: 400px;
            height: 400px;
            top: -100px;
            left: -100px;
        }

        .bg-circles::after {
            width: 500px;
            height: 500px;
            bottom: -150px;
            right: -150px;
        }

        @keyframes float {
            from { transform: translateY(0); }
            to { transform: translateY(40px); }
        }

        /* ===== LOGIN CARD ===== */
        .login-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            backdrop-filter: blur(15px);
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        /* ===== LOGO AREA ===== */
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header img {
            width: 80px;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .app-title {
            font-size: 1.9rem;
            font-weight: 900;
            letter-spacing: 1px;
        }

        .sub-title {
            font-size: 1.1rem;
            opacity: 0.85;
            font-weight: 500;
        }

        /* ===== FORM ===== */
        .form-group {
            margin-top: 1.2rem;
        }

        label {
            display: block;
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
            color: #e8e8e8;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            border-radius: 10px;
            border: none;
            outline: none;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
            color: #222;
            transition: all 0.3s ease;
        }

        input:focus {
            background: #fff;
            box-shadow: 0 0 0 3px rgba(42, 133, 125, 0.4);
        }

        /* ===== ERROR MESSAGE ===== */
        .error {
            color: #ffdddd;
            font-size: 0.85rem;
            margin-top: 0.3rem;
            text-align: center;
        }

        /* ===== BUTTON ===== */
        .btn {
            margin-top: 2rem;
            width: 100%;
            padding: 0.9rem;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #1D665F, #0f4a44);
            color: #fff;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            background: linear-gradient(135deg, #22776f, #165a52);
            transform: translateY(-2px);
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .footer a {
            color: #c7fff2;
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <div class="bg-circles"></div>

    <div class="login-card">
        <div class="header">
            <img src="{{ asset('images/HEALTHSYNC.png') }}" alt="HEALTH SYNC Logo">
            <div class="app-title">HEALTH SYNC</div>
            <div class="sub-title">Masuk ke akun Anda</div>
        </div>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form id="login-form" method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input id="password" type="password" name="password" required>
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn">Masuk</button>
        </form>

        <div class="footer"> HEALTH SYNC </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('login-form');
            form.addEventListener('submit', () => {
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.textContent = 'Sedang memproses...';
            });
        });
    </script>

</body>
</html>
