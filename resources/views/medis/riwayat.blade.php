<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Riwayat Kondisi Lansia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1f8a8a;
            --secondary: #166969;
            --dark: #0f172a;
            --light: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e6f4f1, #d4efec);
            min-height: 100vh;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* ===== Topbar ===== */
        .topbar {
            background: linear-gradient(90deg, var(--primary), #0e4d4d);
            color: var(--light);
            padding: .8rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }

        .brand {
            display: flex;
            align-items: center;
            font-weight: 900;
            font-size: 1.6rem;
            letter-spacing: 1px;
        }

        .brand svg {
            margin-right: 10px;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav a {
            font-weight: 700;
            transition: 0.25s;
            padding: .5rem 1rem;
            border-radius: 9999px;
        }

        .nav a:hover {
            background: rgba(255,255,255,0.15);
        }

        .nav button {
            background: #0f172a;
            color: #fff;
            font-weight: 800;
            border: none;
            border-radius: 9999px;
            padding: .5rem 1.2rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .nav button:hover {
            background: #334155;
        }

        /* ===== Layout ===== */
        .wrap {
            display: flex;
            min-height: calc(100vh - 64px);
        }

        .sidebar {
            width: 270px;
            background: var(--secondary);
            padding: 1.8rem 1.2rem;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 10px rgba(0,0,0,0.15);
        }

        .side-btn {
            display: block;
            background: transparent;
            color: #e5f8f8;
            padding: .8rem 1rem;
            border-radius: 10px;
            font-weight: 700;
            margin-bottom: 1rem;
            text-decoration: none;
            border: 2px solid transparent;
            transition: 0.25s;
        }

        .side-btn:hover {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.3);
        }

        .side-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: #0f172a;
        }

        /* ===== Content ===== */
        .content {
            flex: 1;
            padding: 2rem 3rem;
            background: rgba(255,255,255,0.6);
            backdrop-filter: blur(8px);
            position: relative;
        }

        .panel {
            background: var(--light);
            border-radius: 16px;
            border: 2px solid rgba(15,23,42,0.15);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        .title {
            font-weight: 900;
            font-size: 1.8rem;
            color: var(--dark);
            margin-bottom: 1.5rem;
            position: relative;
        }

        .title::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 80px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        /* ===== Select ===== */
        .label {
            font-weight: 700;
            color: var(--dark);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: .5rem;
            font-size: 0.8rem;
        }

        .select {
            width: 100%;
            max-width: 350px;
            padding: 0.7rem 1rem;
            border-radius: 10px;
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            border: 2px solid var(--dark);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg fill='%23ffffff' height='24' viewBox='0 0 24 24' width='24'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.8rem center;
            background-size: 1rem;
            cursor: pointer;
        }

        /* ===== Table ===== */
        .box {
            margin-top: 2rem;
            border-radius: 12px;
            overflow-x: auto;
            border: 2px solid rgba(15,23,42,0.15);
            box-shadow: 0 6px 12px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            color: var(--dark);
        }

        th {
            background: var(--primary);
            color: #fff;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        th, td {
            padding: 0.9rem 1rem;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }

        tr:hover {
            background-color: #f1f9f8;
        }

        /* ===== Empty Data ===== */
        .empty {
            text-align: center;
            padding: 3rem 1rem;
            font-size: 1.2rem;
            font-weight: 600;
            opacity: 0.7;
        }

        /* ===== Logo Background ===== */
        .logo-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            z-index: 1;
            pointer-events: none;
            text-align: center;
        }

        .logo-bg svg {
            width: 220px;
            height: 220px;
            fill: var(--primary);
        }

        .logo-bg .logo-text {
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: 1px;
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .wrap {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                flex-direction: row;
                justify-content: space-around;
                padding: 1rem;
            }
            .content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="brand">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="3" width="28" height="28" viewBox="0 0 24 24">
                <path d="M12 2v20M4 12h16"></path>
            </svg>
            HEALTH SYNC
        </div>
        <div class="nav">
            <a href="{{ route('medis.dashboard') }}">Home</a>
            <a href="#">Notifikasi</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Keluar</button>
            </form>
        </div>
    </div>

    <div class="wrap">
        <aside class="sidebar">
            <a href="{{ route('medis.riwayat') }}" class="side-btn active">Riwayat Kondisi Lansia</a>
            <a href="{{ route('medis.instruksi.index') }}" class="side-btn">Instruksi Obat</a>
        </aside>

        <main class="content">
            <div class="logo-bg">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                <div class="logo-text">HEALTH SYNC</div>
            </div>

            <div class="panel">
                <div class="title">Riwayat Kondisi Lansia</div>

                <form method="GET" action="{{ route('medis.riwayat') }}">
                    <label class="label">Nama Lansia</label>
                    <select class="select" name="lansia_id" onchange="this.form.submit()">
                        @foreach ($lansia as $l)
                            <option value="{{ $l->id }}" @selected($selectedId == $l->id)>
                                {{ $l->nama_lansia }} ({{ $l->id_lansia }})
                            </option>
                        @endforeach
                    </select>
                </form>

                <div class="box">
                    @if($riwayat->isEmpty())
                        <div class="empty">Tidak ada data riwayat.</div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>TD (Sys/Dia)</th>
                                    <th>Nadi</th>
                                    <th>Suhu</th>
                                    <th>Gula</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayat as $r)
                                    <tr>
                                        <td>{{ $r->diukur_pada->format('d-m-Y H:i') }}</td>
                                        <td>{{ $r->sistol }} / {{ $r->diastol }}</td>
                                        <td>{{ $r->nadi }}</td>
                                        <td>{{ $r->suhu }}°C</td>
                                        <td>{{ $r->gula_darah }} mg/dL</td>
                                        <td>{{ $r->catatan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
