<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Dashboard Medis</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, sans-serif;
            background: linear-gradient(135deg, #2A857D, #1B4E47);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* WRAPPER */
        .main-wrapper {
            width: 100%;
            max-width: 1200px;
            background: #dff4f0;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            display: flex;
            gap: 2rem;
            padding: 2rem 2.5rem;
        }

        /* KIRI - CARD */
        .content-card {
            background: #2A857D;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 2rem 2rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            flex: 1 1 350px;
            max-width: 430px;
        }

        .app-logo {
            width: 100%;
            max-width: 260px;
            height: auto;
            margin-bottom: 2rem;
        }

        .nav-buttons {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .nav-button {
            background: #1D665F;
            color: #fff;
            padding: 1rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transition: background-color .25s ease, transform .2s ease;
            width: 100%;
        }

        .nav-button:hover {
            background: #165751;
            transform: translateY(-3px);
        }

        /* KANAN - SLOGAN + PERAWAT */
        .right-panel {
            flex: 1 1 350px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            gap: 1.5rem;
        }

        .slogan {
            color: #2A857D;
            font-weight: 800;
            font-size: 1.6rem;
            line-height: 1.2;
        }

        .medic-img {
            width: 100%;
            max-width: 420px;
            height: auto;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .main-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .content-card, .right-panel {
                max-width: 100%;
            }
        }
    </style>

</head>
<body>

    <div class="main-wrapper">

        <!-- KIRI: CARD -->
        <div class="content-card">
            <img class="app-logo" src="{{ asset('images/HEALTHSYNC.png') }}" alt="HEALTHSYNC">

            <div class="nav-buttons">
                <a class="nav-button" href="{{ route('medis.riwayat') }}">
                    Riwayat Kondisi Lansia
                </a>

                <a class="nav-button" href="{{ route('medis.instruksi.index') }}">
                    Instruksi Obat
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-button">Logout</button>
                </form>
            </div>
        </div>

        <!-- KANAN: SLOGAN + GAMBAR -->
        <div class="right-panel">
            <div class="slogan">
                Caring with heart, united in Wellness
            </div>
            <img src="{{ asset('images/perawat.png') }}" class="medic-img" alt="Perawat">
        </div>

    </div>

</body>
</html>
