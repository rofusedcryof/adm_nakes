<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengasuh - Admin</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto; margin:0; background:#f8fafc; }
        .wrap { max-width: 1200px; margin: 2rem auto; background:#fff; border-radius:12px; box-shadow: 0 8px 24px rgba(0,0,0,.06); padding:1rem; }
        .row { display:flex; justify-content:space-between; align-items:center; }
        a.btn, button.btn { background:#1f2937; color:#fff; padding:.5rem .8rem; border-radius:8px; text-decoration:none; border:none; cursor:pointer; font-size:.9rem; }
        table { width:100%; border-collapse:collapse; margin-top:1rem; }
        th, td { padding:.55rem .7rem; border-bottom:1px solid #e5e7eb; text-align:left; font-size:.9rem; }
        th { background:#e5f3f3; font-weight:800; }
        form { display:inline; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="row">
            <h2 style="margin:0;">Data Pengasuh</h2>
            <div>
                <a class="btn" href="{{ route('admin.pengasuh.create') }}">Tambah</a>
                <a class="btn" href="{{ route('admin.dashboard') }}">Kembali</a>
            </div>
        </div>

        @if(session('success'))
            <div style="margin:.6rem 0; padding:.6rem; background:#ecfeff; border:1px solid #06b6d4; border-radius:8px;">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengasuh as $p)
                    <tr>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->no_telepon }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>
                            <a class="btn" href="{{ route('admin.pengasuh.edit', $p) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.pengasuh.destroy', $p) }}" onsubmit="return confirm('Hapus data pengasuh ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn" type="submit" style="background:#dc2626;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>

