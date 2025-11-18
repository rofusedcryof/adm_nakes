<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Dashboard Medis</title>

    <style>
        body { 
            margin: 0; 
            font-family: system-ui, sans-serif;
            background: linear-gradient(135deg, #2A857D, #1B4E47);
            display: flex; 
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 0; 
            overflow: hidden; 
        }

        .main-wrapper {
            width: 90%; 
            max-width: 1200px; 
            height: 80vh; 
            max-height: 650px; 
            background: #dff4f0; 
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            position: relative; 
            display: flex; 
            align-items: center;
            overflow: hidden; 
        }

        .main-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 90%;
            height: 110%;
            background: url('{{ asset('images/perawat.png') }}') no-repeat;
            background-size: 40%; 
            background-position: right center; 
            z-index: 1; 
        }

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

        .app-logo {
            max-width: 75%; 
            width: 100%;
            height: auto;
            filter: brightness(1.2); 
            opacity: 0.9;
            margin-top: -1rem; 
        }

        .slogan-overlay {
            position: absolute;
            top: 10%;
            right: 10%;
            width: 40%; 
            color: #2A857D;
            text-align: right;
            font-weight: 800;
            font-size: 1.6rem;
            z-index: 5;
        }

        .nav-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem; 
            justify-content: center;
            width: 100%;
        }

        .nav-button {
            background: #1D665F; 
            color: #fff;
            padding: 1rem 0.8rem; 
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
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
    </style>
</head>
<body>

    <div class="main-wrapper">

        <div class="content-card">
            <img class="app-logo" src="{{ asset('images/HEALTHSYNC.png') }}" alt="HEALTHSYNC ELDERLY MONITORING">

            <div class="nav-buttons">
                <a class="nav-button" href="{{ route('medis.riwayat') }}">
                    Riwayat Kondisi Lansia
                </a>

                <a class="nav-button" href="{{ route('medis.instruksi.index') }}">
                    Instruksi Obat
                </a>

                <form action="{{ route('logout') }}" method="POST" style="flex:1 1 45%; display:flex;">
                    @csrf
                    <button type="submit" class="nav-button" style="width:100%;">Logout</button>
                </form>

            </div>
        </div>

        <div class="slogan-overlay">
            Caring with heart, united in Wellness
        </div>

    </div>

</body>
</html>
