<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Obat - Admin</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto; margin:0; background:#f8fafc; }
        .wrap { max-width: 1200px; margin: 2rem auto; background:#fff; border-radius:12px; box-shadow: 0 8px 24px rgba(0,0,0,.06); padding:1rem; }
        .row { display:flex; justify-content:space-between; align-items:center; }
        a.btn, button.btn { background:#1f2937; color:#fff; padding:.5rem .8rem; border-radius:8px; text-decoration:none; border:none; cursor:pointer; font-size:.9rem; }
        table { width:100%; border-collapse:collapse; margin-top:1rem; }
        th, td { padding:.55rem .7rem; border-bottom:1px solid #e5e7eb; text-align:left; font-size:.9rem; }
        th { background:#e5f3f3; font-weight:800; }
        form { display:inline; }
        .badge { padding:.25rem .5rem; border-radius:6px; font-size:.8rem; font-weight:600; }
        .badge-aktif { background:#d1fae5; color:#065f46; }
        .badge-selesai { background:#dbeafe; color:#1e40af; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="row">
            <h2 style="margin:0;">Instruksi Obat Lansia</h2>
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
                    <th>Medis</th>
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
                        <td>{{ $it->medis->name ?? '-' }}</td>
                        <td>
                            <a class="btn" href="{{ route('admin.instruksi.edit', $it) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.instruksi.destroy', $it) }}" onsubmit="return confirm('Hapus instruksi obat ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn" type="submit" style="background:#dc2626;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:1rem;">{{ $items->links() }}</div>
    </div>
</body>
</html>

