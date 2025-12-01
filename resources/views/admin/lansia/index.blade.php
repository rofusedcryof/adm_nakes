<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Lansia</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f6f7fb;margin:0}
        .topbar{background:#0d6b6b;color:#fff;padding:14px 16px;display:flex;justify-content:space-between;align-items:center}
        .container{padding:16px}
        .btn{background:#0d6b6b;color:#fff;border:none;border-radius:8px;padding:10px 14px;cursor:pointer;text-decoration:none}
        table{width:100%;border-collapse:collapse;background:#fff;border-radius:12px;overflow:hidden}
        th,td{padding:12px;border-bottom:1px solid #eee;text-align:left}
        th{background:#eaf6f6}
    </style>
</head>
<body>
<div class="topbar">
    <div>HEALTH SYNC</div>
    <div>
        <a href="{{ route('admin.lansia.create') }}" class="btn">Tambah Lansia + Akun Keluarga</a>
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background:#245b5b;margin-left:8px">Home</a>
    </div>
</div>
<div class="container">
    @if(session('success'))
        <div style="background:#e9fff1;color:#0f5132;padding:10px;border-radius:8px;margin-bottom:12px">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID Lansia</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Keluarga</th>
            </tr>
        </thead>
        <tbody>
        @forelse($items as $l)
            <tr>
                <td>{{ $l->id_lansia }}</td>
                <td>{{ $l->nama_lansia }}</td>
                <td>{{ $l->alamat }}</td>
                <td>
                    @php $kel = $l->keluarga->first(); @endphp
                    {{ $kel?->nama }} ({{ $kel?->email }})
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada data.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">{{ $items->links() }}</div>
</div>
</body>
</html>
