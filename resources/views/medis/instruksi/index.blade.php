<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Instruksi Obat</title>

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

        /* === CONTENT AREA === */
        .content {
            background: #2A857D;
            border-radius: 15px;
            padding: 3rem;
            min-height: calc(100vh - 150px);
            position: relative;
            overflow: hidden;
        }

        .logo-placeholder {
            max-width: 350px;
            opacity: 0.35;
            position: absolute;
            top: 54%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* === PANEL PUTIH PANJANG === */
        .panel {
            background: white;
            width: 95%;
            margin-left: auto;
            margin-right: auto;
            padding: 1.8rem 2rem;
            border-radius: 12px;
            z-index: 10;
            position: relative;
            box-shadow: 0 4px 10px rgba(0,0,0,0.12);
        }

        h2 {
            font-size: 1.7rem;
            font-weight: 900;
            margin-bottom: 1rem;
        }

        /* Button Tambah */
        .add-btn {
            background: #2A857D;
            color: white;
            padding: .45rem .9rem;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.2rem;
        }
        th {
            background: #e0f2f1;
            color: #000;
            padding: 0.75rem;
            font-weight: 800;
            text-align: left;
        }
        td {
            padding: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
            background: white;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
            padding: .35rem .8rem;
            border-radius: 8px;
            font-weight: 700;
        }

        .action-btn {
            background: #263238;
            color: white;
            padding: .4rem .9rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin-right: 4px;
        }
        .delete-btn {
            background: #d62828;
        }

        .box {
            margin-top: 0.8rem;
            border-radius: 12px;
            padding: 1rem;
            min-height: 120px;
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

        <div class="panel">

            <h2>Instruksi Obat Lansia</h2>

            <div style="display:flex; justify-content:space-between; align-items:center;">
                <strong style="font-size:1.1rem;">Daftar Instruksi</strong>
                <a href="{{ route('medis.instruksi.create') }}" class="add-btn">+ Tambah Instruksi</a>
            </div>

            <div class="box">

                @if($items->isEmpty())
                    <p style="margin-top: 2rem; font-size: 1.1rem; color: #555; text-align:center;">
                        Tidak ada instruksi obat.
                    </p>
                @else

                <table>
                    <thead>
                        <tr>
                            <th>Lansia</th>
                            <th>Nama Obat</th>
                            <th>Dosis</th>
                            <th>Frekuensi</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Status</th>
                            <th>Medis</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($items as $i)
                        <tr>
                            <td>{{ $i->lansia->nama_lansia }}</td>
                            <td><strong>{{ $i->nama_obat }}</strong></td>
                            <td>{{ $i->dosis }}</td>
                            <td>{{ $i->frekuensi }}</td>
                            <td>{{ $i->mulai_pada }}</td>
                            <td>{{ $i->selesai_pada }}</td>

                            <td>
                                @if($i->status === 'aktif')
                                    <span class="status-active">Aktif</span>
                                @else
                                    <span class="status-active" style="background:#fee2e2; color:#991b1b;">Selesai</span>
                                @endif
                            </td>

                            <td>{{ $i->medis->name ?? '-' }}</td>

                            <td style="text-align:center;">
                                <a href="{{ route('medis.instruksi.edit', $i->id) }}" class="action-btn">Edit</a>

                                <form method="POST" action="{{ route('medis.instruksi.destroy', $i->id) }}" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus instruksi ini?')" class="action-btn delete-btn">
                                        Hapus
                                    </button>
                                </form>
                            </td>
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
