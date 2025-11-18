<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Riwayat Kondisi Lansia</title>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu;
            background: #f0f9f9;
            padding: 1.5rem;
        }

        /* === TOPBAR === */
        .topbar {
            background: #2A857D;
            color: #fff;
            padding: 1.5rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .brand {
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }
        .nav-right {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        .nav-right a {
            color: white;
            font-weight: 700;
            text-decoration: none;
        }
        .logout {
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
            padding: .45rem .7rem;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
        }

        /* === CONTENT AREA === */
        .content {
            background: #2A857D;
            border-radius: 15px;
            padding: 2.5rem;
            min-height: calc(100vh - 150px);
            position: relative;
            display: flex;
            justify-content: center;
            overflow: hidden;
        }

        .logo-placeholder {
            max-width: 320px;
            opacity: 0.45;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* --- PANEL PUTIH --- */
        .content-overlay {
    position: relative;        /* ubah dari absolute → relative */
    width: 95%;
    max-width: 1300px;
    margin: 0 auto;            /* supaya tetap di tengah */
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    min-height: 200px;         /* boleh diubah sesuai kebutuhan */
    z-index: 10;
}


        }

        /* Teks Judul */
        h2 {
            font-size: 1.6rem;
            font-weight: 900;
            margin-bottom: 1rem;
        }

        /* Dropdown */
        label {
            font-size: 0.85rem;
            font-weight: bold;
            margin-bottom: .3rem;
            display: block;
        }
        .select {
            width: 300px;
            padding: .55rem .7rem;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        /* Box untuk tabel */
       .box {
    margin-top: 1.5rem;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    padding: 1.5rem;
    text-align: center;
    height: 260px;     /* TINGGI PANEL PUTIH */
    display: flex;
    justify-content: center;
    align-items: center;
}


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th {
            background: #2A857D;
            color: white;
            padding: .7rem;
            font-weight: 800;
        }
        th, td {
            border-bottom: 1px solid #e5e7eb;
            padding: .7rem;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- === TOPBAR === -->
    <div class="topbar">
        <div class="brand">HEALTH SYNC</div>

        <div class="nav-right">
             <a href="#">NOTIFIKASI</a>
            <a href="{{ route('medis.dashboard') }}">HOME</a>

        </div>
    </div>

    <!-- === CONTENT === -->
    <main class="content">
        <img class="logo-placeholder" src="{{ asset('images/HEALTHSYNC.png') }}">

        <div class="content-overlay">
            
            <h2>Riwayat Kondisi Lansia</h2>

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

            <div class="box">
                @if($riwayat->isEmpty())
                    <p style="margin-top: 2rem; font-size: 1.1rem; color: #555;">
                        Tidak ada data riwayat.
                    </p>
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

</body>
</html>
