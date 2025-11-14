<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Jadwal Kegiatan</title>
    <style>
        /* CSS LAYOUT LENGKAP */
        body { 
            margin: 0; 
            min-height: 100vh;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial; 
            background: #f0f9f9; 
            padding: 1.5rem;
        }
        .topbar { 
            background: #2A857D; color: #fff; padding: 1.5rem 2.5rem; display: flex; 
            align-items: center; justify-content: space-between; margin-bottom: 1.5rem;
            border-radius: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .brand { font-weight: 900; letter-spacing: 1px; font-size: 1.5rem; }
        .nav { display: flex; gap: 2rem; align-items: center; justify-content: space-between; width: 100%; }
        .nav-right { display: flex; align-items: center; gap: 2rem; margin-left: auto; }
        .nav a { color: #fff; text-decoration: none; font-weight: 700; font-size: 1rem; }
        .wrap { display: flex; min-height: calc(100vh - 130px); gap: 1.5rem; }
        .sidebar { 
            width: 180px; min-width: 180px; background: #2A857D; padding: 1.5rem; 
            display: flex; align-items: center; border-radius: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .side-menu { width: 100%; }
        .side-btn { 
            display: flex; align-items: center; justify-content: flex-start; width: 100%; 
            background: #1D665F; color: #fff; padding: 0.8rem 1.2rem; font-size: 0.9rem;
            font-weight: 500; margin-bottom: 0.8rem; text-decoration: none; border: none; 
            transition: all 0.3s ease; border-radius: 50px; cursor: pointer; white-space: nowrap;
        }
        .side-btn:hover { background: #165751; transform: translateX(5px); }
        .side-btn.active { 
            background: #165751; box-shadow: 0 0 10px rgba(0,0,0,0.2); font-weight: 700;
        }
        .content { 
            flex: 1; display: flex; flex-direction: column; align-items: center; 
            justify-content: center; background: #2A857D; border-radius: 15px; 
            margin: 0 auto; padding: 2.5rem; width: 100%; min-height: calc(100vh - 150px); 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); position: relative; overflow: hidden;
        }
        .logout { background: transparent; color: #fff; border: 2px solid #fff; padding: .45rem .7rem; border-radius: 5px; font-weight: 600; cursor: pointer; }

        /* Konten Overlay (Tabel Jadwal) */
        .card-overlay {
            /* PERBAIKAN: Mengatur margin dan ukuran agar sama dengan file instruksi obat */
            position: absolute; 
            top: 30px;    /* Margin Atas 30px */
            left: 30px;   /* Margin Kiri 30px */
            right: 30px;  /* Margin Kanan 30px */
            max-height: calc(100% - 60px); /* Tinggi total dikurangi margin atas & bawah */
            overflow-y: auto; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 4px 15px rgba(0,0,0,.2);
            padding: 1.5rem; 
            z-index: 10; 
            width: auto; /* Dibiarkan auto karena left dan right sudah diatur */
            max-width: none;
        }
        
        /* Gaya Tabel */
        .card-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;
        }
        .btn-action {
            background: #1f2937; color: #fff; padding: .45rem .8rem; border-radius: 6px;
            text-decoration: none; border: none; cursor: pointer; font-size: .85rem;
        }
        .btn-tambah { background: #2A857D; }
        .btn-kembali { background: #6c757d; }
        .btn-hapus { background: #dc3545; }
        .btn-edit { background: #1f2937; }
        table { width:100%; border-collapse:collapse; margin-top:1rem; }
        th, td { padding:.55rem .7rem; border-bottom:1px solid #e5e7eb; text-align:left; font-size:.9rem; }
        th { background:#e5f3f3; font-weight:800; }
        form { display:inline; }
        .logo-placeholder { max-width: 300px; width: 100%; height: auto; filter: brightness(1.1); opacity: 0.6; }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="nav">
            <div class="brand">HEALTH SYNC</div>
            <div class="nav-right">
                <a href="{{ route('admin.dashboard') }}">HOME</a>
                <a href="#">NOTIFIKASI</a>
                <form class="footer" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout" type="submit">Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="wrap">
        <aside class="sidebar">
            <div class="side-menu">
                <a class="side-btn active" href="{{ route('admin.jadwal.index') }}">
                    Jadwal Kegiatan
                </a>
                <a class="side-btn" href="{{ route('admin.instruksi.index') }}">
                    Instruksi Obat
                </a>
            </div>
        </aside>
        
        <main class="content">
            <img class="logo-placeholder" src="{{ asset('images/HEALTHSYNC.png') }}" alt="HEALTHSYNC">

            <div class="card-overlay">
                
                <div class="card-header">
                    <h2 style="margin:0;">Jadwal Kegiatan Lansia</h2>

                    <div>
                        <a class="btn-action btn-tambah" href="{{ route('admin.jadwal.create') }}">Tambah</a>
                        <a class="btn-action btn-kembali" href="{{ route('admin.dashboard') }}">Kembali</a>
                    </div>
                </div>

                @if(session('status'))
                    <div style="background:#d1fae5; padding:.7rem 1rem; border-radius:6px; margin-bottom:1rem;">
                        {{ session('status') }}
                    </div>
                @endif

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
                                    <a class="btn-action btn-edit" href="{{ route('admin.jadwal.edit', $item) }}">Edit</a>

                                    <form method="POST" action="{{ route('admin.jadwal.destroy', $item) }}" 
                                            onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-hapus">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Belum ada jadwal kegiatan.</td>
                            </tr>
                        @endforelse 
                    </tbody>
                </table>
                 <div style="margin-top:1rem;">
                    {{ $items->links() }} 
                </div>

            </div>
        </main>
    </div>
</body>
</html>