<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Jadwal Kegiatan Lansia</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#F3F4F6;padding:1rem}
        .card{background:#fff;padding:1rem;border-radius:8px;margin-bottom:1rem;box-shadow:0 1px 3px rgba(0,0,0,0.08)}
        .header{font-weight:700;color:#0f766e;margin-bottom:0.5rem}
        .btn{background:#2A857D;color:#fff;padding:0.5rem 0.75rem;border-radius:6px;text-decoration:none}
        .list-item{padding:0.5rem;border-radius:6px;background:#F8FAFC;margin-bottom:0.5rem;display:flex;justify-content:space-between;align-items:center}
        .empty{color:#6B7280}
        table{width:100%;border-collapse:collapse}
        th,td{padding:0.5rem;border-bottom:1px solid #E5E7EB;text-align:left}
    </style>
</head>
<body>
    <div class="card">
        <div class="header">Jadwal Kegiatan Lansia</div>
        <div style="margin-bottom:0.5rem;">
            <a href="{{ route('pengasuh.kegiatan-lansia.index') }}" class="btn">Semua Lansia</a>
            <a href="{{ route('pengasuh.dashboard') }}" style="margin-left:0.5rem">Kembali</a>
        </div>

        <div>
            <strong>Pilih Lansia:</strong>
            @if(isset($allLansia) && $allLansia->count() > 0)
                @foreach($allLansia as $item)
                    <div class="list-item">
                        <div>{{ $item->nama_lansia }} ({{ $item->id_lansia }})</div>
                        <div><a href="{{ route('pengasuh.kegiatan-lansia.show', $item->id_lansia) }}" class="btn" style="background:#0ea5a4">Lihat Jadwal</a></div>
                    </div>
                @endforeach
            @else
                <div class="empty">Belum ada data lansia</div>
            @endif
        </div>
    </div>

    @if(isset($lansia) && isset($jadwals))
    <div class="card">
        <div class="header">Jadwal: {{ $lansia->nama_lansia }} ({{ $lansia->id_lansia }})</div>
        @if($jadwals->count() > 0)
            <table>
                <thead>
                    <tr><th>Tanggal</th><th>Waktu</th><th>Kegiatan</th></tr>
                </thead>
                <tbody>
                    @foreach($jadwals as $j)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }}</td>
                            <td>{{ $j->waktu }}</td>
                            <td>{{ $j->aktivitas }}</td> <!-- Ganti 'kegiatan' jadi 'aktivitas' -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty">Belum ada jadwal untuk lansia ini</div>
        @endif
    </div>
    @endif
</body>
</html>