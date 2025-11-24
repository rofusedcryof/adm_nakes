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
            margin-bottom: 2rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        }

        .brand {
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }

        .nav-right {
            display: flex;
            gap: 2rem;
        }

        .nav-right a {
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
        }

        /* === CONTENT BACKGROUND === */
        .content {
            background: #2A857D;
            border-radius: 15px;
            padding: 3rem 2.5rem;
            min-height: calc(100vh - 180px);
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        /* LOGO BESAR DI BELAKANG */
        .logo-placeholder {
            max-width: 360px;
            opacity: 0.28;
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            pointer-events: none;
        }

        /* === PANEL PUTIH === */
        .panel {
            background: white;
            width: 95%;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            position: relative;
            z-index: 10;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h2 {
            margin-top: 0;
            font-size: 1.8rem;
            font-weight: 900;
            color: #000;
        }

        /* Button Tambah */
        .add-btn {
            background: #2A857D;
            color: white;
            padding: .6rem .9rem;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            font-size: .9rem;
        }

        /* === TABLE === */
        .table-container {
            margin-top: 1.3rem;
            padding: 0.5rem 0.3rem;
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        th {
            background: #dff4f0;
            color: #004d40;
            padding: 0.9rem;
            font-weight: 800;
            font-size: 0.95rem;
            border-bottom: 2px solid #cfe8e4;
        }

        td {
            padding: 0.85rem 0.9rem;
            font-size: 0.9rem;
            border-bottom: 1px solid #e6e6e6;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status badge */
        .status-active {
            background: #d1fae5;
            color: #065f46;
            padding: 0.4rem 0.7rem;
            border-radius: 8px;
            font-weight: 700;
        }

        .status-done {
            background: #fee2e2;
            color: #991b1b;
            padding: 0.4rem 0.7rem;
            border-radius: 8px;
            font-weight: 700;
        }

        /* Aksi */
        .action-btn {
            background: #1f2937;
            color: white;
            padding: .45rem .9rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 5px;
            display: inline-block;
        }

        .delete-btn {
            background: #d62828;
        }

        /* Responsive */
        @media(max-width: 700px){
            .panel-header {
                flex-direction: column;
                align-items: flex-start;
                gap: .8rem;
            }

            .add-btn {
                width: 100%;
                text-align: center;
            }

            table {
                font-size: .85rem;
            }
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

    <!-- === CONTENT AREA === -->
    <main class="content">

        <img class="logo-placeholder" src="{{ asset('images/HEALTHSYNC.png') }}">

        <div class="panel">

            <div class="panel-header">
                <h2>Instruksi Obat Lansia</h2>
                <a href="{{ route('medis.instruksi.create') }}" class="add-btn">+ Tambah Instruksi</a>
            </div>

            <strong>Daftar Instruksi</strong>

            <div class="table-container">

                @if($items->isEmpty())
                    <p style="text-align:center; margin-top:2rem; color:#444;">
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
                                    <span class="status-done">Selesai</span>
                                @endif
                            </td>

                            <td>{{ $i->medis->name ?? '-' }}</td>

                            <td style="text-align:center; white-space:nowrap;">
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
