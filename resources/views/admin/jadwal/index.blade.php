<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kegiatan Lansia - Admin</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto; margin:0; background:#f8fafc; }
        .wrap { max-width: 1000px; margin: 2rem auto; background:#fff; border-radius:12px; box-shadow: 0 8px 24px rgba(0,0,0,.06); padding:1rem; }
        .row { display:flex; justify-content:space-between; align-items:center; }
        a.btn, button.btn { background:#1f2937; color:#fff; padding:.5rem .8rem; border-radius:8px; text-decoration:none; border:none; cursor:pointer; }
        table { width:100%; border-collapse:collapse; margin-top:1rem; }
        th, td { padding:.55rem .7rem; border-bottom:1px solid #e5e7eb; text-align:left; }
        th { background:#e5f3f3; }
        form { display:inline; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="row">
            <h2 style="margin:0;">Jadwal Kegiatan Lansia</h2>
            <div>
                <a class="btn" href="{{ route('admin.jadwal.create') }}">Tambah</a>
                <a class="btn" href="{{ route('admin.dashboard') }}">Kembali</a>
            </div>
        </div>

        @if(session('ok'))
            <div style="margin:.6rem 0; padding:.6rem; background:#ecfeff; border:1px solid #06b6d4;">{{ session('ok') }}</div>
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
                @forelse ($items as $it)
                    <tr>
                        <td>{{ $it->id_jadwal ?? '-' }}</td>
                        <td>{{ $it->lansia->nama_lansia ?? '-' }}</td>
                        <td>{{ $it->tanggal?->format('d-m-Y') ?? '-' }}</td>
                        <td>{{ $it->waktu ?? '-' }}</td>
                        <td>{{ $it->aktivitas ?? '-' }}</td>
                        <td>
                            <a class="btn" href="{{ route('admin.jadwal.edit', $it) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.jadwal.destroy', $it) }}" onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:1rem;">{{ $items->links() }}</div>
    </div>
</body>
</html>


