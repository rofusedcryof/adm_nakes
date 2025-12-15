<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HEALTH SYNC - Riwayat Kondisi Lansia</title>

    <style>
        body {
            margin: 0;
            background: #f0f9f9;
            padding: 1.5rem;
            font-family: system-ui, sans-serif;
        }

        /* TOPBAR */
        .topbar {
            background: #2A857D;
            color: white;
            padding: 1.5rem 2.5rem;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            margin-bottom: 2rem;
        }
        .brand { font-size: 1.5rem; font-weight: 900; }
        .nav-right a {
            color: white;
            text-decoration: none;
            margin-left: 2rem;
            font-weight: bold;
        }

        /* CONTENT BACKGROUND */
        .content {
            background: #2A857D;
            border-radius: 15px;
            padding: 3rem 2.5rem;
            min-height: calc(100vh - 180px);
            position: relative;
            display: flex;
            justify-content: center;
            overflow: hidden;
        }
        .logo-placeholder {
            position: absolute;
            bottom: 20px;
            opacity: 0.25;
            width: 320px;
            left: 50%;
            transform: translateX(-50%);
        }

        /* PANEL PUTIH (SIMILAR TO AKTIVITAS/INSTRUKSI OBAT) */
        .panel {
            background: white;
            width: 95%;
            max-width: 1100px;
            border-radius: 12px;
            padding: 2rem 2.5rem;
            box-shadow: 0 4px 14px rgba(0,0,0,.15);
        }

        /* FORM */
        label {
            font-weight: bold;
            margin-bottom: .4rem;
            display: block;
        }
        .select {
            width: 300px;
            padding: .55rem .7rem;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        /* BOX TABLE */
        .table-box {
            margin-top: 1.5rem;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 1rem 1rem;
            background: #fafafa;
        }

        /* TABEL */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: .8rem;
        }
        th {
            background: #2A857D;
            color: white;
            padding: .8rem;
            font-weight: 800;
            text-align: center;
        }
        td {
            padding: .8rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
        }
        tr:last-child td { border-bottom: none; }

        .no-data {
            padding: 2rem 0;
            font-size: 1rem;
            color: #666;
        }
    </style>
</head>

<body>

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="brand">HEALTH SYNC</div>
        <div class="nav-right">
            <a href="#">NOTIFIKASI</a>
            <a href="{{ route('medis.dashboard') }}">HOME</a>
        </div>
    </div>

    <!-- CONTENT -->
    <main class="content">
        <img class="logo-placeholder" src="{{ asset('images/HEALTHSYNC.png') }}">

        <div class="panel">
            <h2 style="font-size: 1.7rem; margin-bottom:1rem;">Riwayat Kondisi Lansia</h2>

            <form method="GET" action="{{ route('medis.riwayat') }}">
                <label>Nama Lansia</label>
                <select class="select" name="lansia_id" onchange="this.form.submit()">
                    @foreach ($lansia as $l)
                        <option value="{{ $l->id }}" @selected($selectedId == $l->id)>
                            {{ $l->nama_lansia }} ({{ $l->id_lansia }})
                        </option>
                    @endforeach
                </select>
            </form>

            <div class="table-box">
                @if($riwayat->isEmpty())
                    <p class="no-data">Tidak ada data riwayat.</p>
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

    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", function() {
                navigator.serviceWorker.register("/sw.js");
            });
        }
    </script>
    <script src="{{ asset('push-notification.js') }}"></script>

</body>
</html>
