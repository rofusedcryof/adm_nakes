<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Obat - Tenaga Medis</title>
    <style>
        body { margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto; background:#ffffff; }
        .topbar { background:#1f8a8a; color:#fff; padding:.6rem 1rem; border:3px solid #0f172a; display:flex; align-items:center; justify-content:space-between; }
        .brand { font-weight:900; letter-spacing:.8px; font-size:1.35rem; }
        .nav { display:flex; gap:1.25rem; align-items:center; }
        .nav a { color:#fff; text-decoration:none; font-weight:700; font-size:.9rem; }
        .wrap { display:flex; }
        .sidebar { width:220px; min-height: calc(100vh - 52px); background:#247e81; padding: .75rem; border-right: 2px solid #0f172a; }
        .side-btn { display:block; width:100%; background:#fff; color:#111827; padding:.55rem .7rem; border-radius:18px; font-weight:800; margin:.7rem 0; text-align:left; border:2px solid #0f172a; box-shadow:0 2px 0 rgba(0,0,0,.2); box-sizing:border-box; }
        .side-btn.active { background:#e5f3f3; }
        .content { flex:1; padding:1.25rem; }
        table { width:100%; border-collapse:collapse; margin-top:1rem; background:#fff; border: 2px solid #d1d5db; border-radius:10px; overflow:hidden; }
        th, td { padding:.55rem .7rem; border-bottom:1px solid #e5e7eb; text-align:left; }
        th { background:#e5f3f3; font-weight:800; }
        .badge { padding:.25rem .5rem; border-radius:6px; font-size:.8rem; font-weight:600; }
        .badge-aktif { background:#d1fae5; color:#065f46; }
        .badge-selesai { background:#dbeafe; color:#1e40af; }
        .logout { background:#0f172a; color:#fff; border:none; padding:.45rem .7rem; border-radius:18px; font-weight:800; cursor:pointer; }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="brand">HEALTH SYNC</div>
        <div class="nav">
            <a href="{{ route('medis.dashboard') }}">HOME</a>
            <a href="#">NOTIFIKASI</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button class="logout" type="submit">Keluar</button>
            </form>
        </div>
    </div>

    <div class="wrap">
        <aside class="sidebar">
            <a class="side-btn" href="{{ route('medis.riwayat') }}">Riwayat Kondisi Lansia</a>
            <a class="side-btn active" href="{{ route('medis.instruksi.index') }}">Instruksi Obat</a>
        </aside>
        <main class="content">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                <h2 style="margin:0;">Instruksi Obat</h2>
                <a href="{{ route('medis.instruksi.create') }}" style="background:#1f2937; color:#fff; padding:.5rem .8rem; border-radius:8px; text-decoration:none; font-weight:600;">Tambah Instruksi</a>
            </div>

            @if(session('ok'))
                <div style="margin:.6rem 0; padding:.6rem; background:#ecfeff; border:1px solid #06b6d4; border-radius:8px;">{{ session('ok') }}</div>
            @endif

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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $it)
                        <tr>
                            <td>{{ $it->lansia->nama_lansia ?? '-' }}</td>
                            <td><strong>{{ $it->nama_obat }}</strong></td>
                            <td>{{ $it->dosis ?? '-' }}</td>
                            <td>{{ $it->frekuensi ?? '-' }}</td>
                            <td>{{ $it->mulai_pada?->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ $it->selesai_pada?->format('d-m-Y') ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $it->status === 'aktif' ? 'badge-aktif' : 'badge-selesai' }}">
                                    {{ ucfirst($it->status ?? '-') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('medis.instruksi.edit', $it) }}" style="background:#1f2937; color:#fff; padding:.4rem .6rem; border-radius:8px; text-decoration:none; font-size:.85rem; margin-right:.4rem;">Edit</a>
                                <form method="POST" action="{{ route('medis.instruksi.destroy', $it) }}" style="display:inline;" onsubmit="return confirm('Hapus instruksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:#dc2626; color:#fff; padding:.4rem .6rem; border-radius:8px; border:none; cursor:pointer; font-size:.85rem;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8">Belum ada instruksi obat.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top:1rem;">{{ $items->links() }}</div>
        </main>
    </div>
</body>
</html>

