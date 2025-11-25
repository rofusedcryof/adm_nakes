<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Jadwal Kegiatan</title>
    <style>
        body { 
            margin: 0; 
            min-height: 100vh;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial; 
            background: #f0f9f9; 
            padding: 1.5rem;
        }

        .topbar { 
            background: #2A857D; 
            color: #fff; 
            padding: 1.5rem 2.5rem; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            margin-bottom: 1.5rem;
            border-radius: 15px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .brand { 
            font-weight: 900; 
            letter-spacing: 1px; 
            font-size: 1.5rem; 
        }

        .nav { 
            display: flex; 
            gap: 2rem; 
            align-items: center; 
            justify-content: space-between; 
            width: 100%; 
        }

        .nav-right { 
            display: flex; 
            align-items: center; 
            gap: 2rem; 
            margin-left: auto; 
        }

        .nav a { 
            color: #fff; 
            text-decoration: none; 
            font-weight: 700; 
            font-size: 1rem; 
        }

        .wrap { 
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .content { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            background: #2A857D; 
            border-radius: 15px; 
            margin: 0 auto; 
            padding: 2.5rem; 
            width: 100%; 
            min-height: calc(100vh - 150px); 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            position: relative; 
            overflow: hidden;
        }

        .logo-placeholder { 
            max-width: 300px; 
            width: 100%; 
            height: auto; 
            filter: brightness(1.1); 
            opacity: 0.6; 
        }

        .card-overlay {
            position: absolute; 
            top: 30px;
            left: 30px;
            right: 30px;
            max-height: calc(100% - 60px);
            overflow-y: auto; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 4px 15px rgba(0,0,0,.2);
            padding: 1.5rem; 
            z-index: 10; 
            width: auto;
        }

        .card-header {
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 1rem;
        }

        .btn-action {
            padding: .45rem .9rem;
            border-radius: 6px;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: .85rem;
            text-decoration: none;
        }

        .btn-tambah { background: #2A857D; }

        table { width:100%; border-collapse:collapse; margin-top:1rem; min-width:700px; }
        th, td { padding:.55rem .7rem; border-bottom:1px solid #e5e7eb; text-align:left; font-size:.9rem; }
        th { background:#e5f3f3; font-weight:800; }

        form { display:inline; }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        /* ---------------------------- */
        /* EDIT + HAPUS  */
        /* ---------------------------- */

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        /* Hilangkan underline */
        .action-buttons a {
            text-decoration: none;
        }

        .btn-edit, .btn-hapus {
            padding: .45rem .9rem;
            font-size: .85rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color: white;
            flex: 1;                 /* Kunci agar tombol sama panjang */
            text-align: center;
            display: inline-block;
        }

        .btn-edit { background: #1f2937; }
        .btn-hapus { background: #dc3545; }

        @media (max-width: 600px) {
            .action-buttons {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-edit,
            .btn-hapus {
                width: 100%;
                max-width: 120px;
                flex: none;
            }
        }
    </style>
</head>

<body>

    <div class="topbar">
        <div class="nav">
            <div class="brand">HEALTH SYNC</div>
            <div class="nav-right">
                <a href="{{ route('admin.dashboard') }}">HOME</a>
            </div>
        </div>
    </div>

    <div class="wrap">
        <main class="content">

            <img class="logo-placeholder" src="{{ asset('images/HEALTHSYNC.png') }}" alt="HEALTHSYNC">

            <div class="card-overlay">
                
                <div class="card-header">
                    <h2 style="margin:0;">Jadwal Kegiatan Lansia</h2>
                    <a class="btn-action btn-tambah" href="{{ route('admin.jadwal.create') }}">Tambah</a>
                </div>

                @if(session('status'))
                    <div style="background:#d1fae5; padding:.7rem 1rem; border-radius:6px; margin-bottom:1rem;">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID Jadwal</th>
                                <th>Lansia</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item->id_jadwal }}</td>
                                    <td>{{ $item->lansia->nama_lansia ?? 'N/A' }}</td>
                                    <td>{{ $item->tanggal?->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $item->waktu ?? '-' }}</td>
                                    <td>{{ $item->aktivitas }}</td>

                                    <td>
                                        <div class="action-buttons">

                                            <a href="{{ route('admin.jadwal.edit', $item) }}" class="btn-edit">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route('admin.jadwal.destroy', $item) }}" 
                                                onsubmit="return confirm('Hapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-hapus">Hapus</button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Belum ada jadwal kegiatan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:1rem;">
                    {{ $items->links() }}
                </div>

            </div>

        </main>
    </div>

</body>
</html>
