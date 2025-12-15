<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Notifikasi Medis</title>
    <style>
        body { margin:0; font-family:system-ui, sans-serif; background:#e8f5f3; }
        .topbar { background:#2A857D; color:white; padding:1rem 1.5rem; font-weight:800; display:flex; justify-content:space-between; align-items:center; }
        .wrap { max-width:1000px; margin:0 auto; padding:1rem; }
        .card { background:white; border-radius:12px; box-shadow:0 6px 16px rgba(0,0,0,0.12); padding:1rem; margin-top:1rem; }
        .notif-item { border-left:4px solid #2A857D; padding:0.8rem; border-radius:8px; background:#f9fafb; margin-bottom:10px; }
        .notif-title { font-weight:700; color:#213; margin-bottom:4px; }
        .notif-meta { font-size:.8rem; color:#666; }
        .empty { text-align:center; color:#555; padding:1rem; }
        .btn-back { background:#1D665F; color:white; border:none; padding:.5rem .9rem; border-radius:8px; text-decoration:none; font-weight:700; }
    </style>
</head>
<body>
    <div class="topbar">
        <div>HEALTH SYNC</div>
        <div>
            <a class="btn-back" href="{{ route('medis.dashboard') }}">Kembali</a>
        </div>
    </div>

    <div class="wrap">
        <div class="card">
            <h2 style="margin:0 0 .8rem 0;">Notifikasi</h2>
            @if($items->isEmpty())
                <div class="empty">Belum ada notifikasi.</div>
            @else
                @foreach($items as $n)
                    <div class="notif-item">
                        <div class="notif-title">{{ $n->pesan }}</div>
                        <div class="notif-meta">
                            {{ $n->created_at->format('d/m/Y H:i') }}
                            @if(is_array($n->data_json))
                                @php $d = $n->data_json; @endphp
                                @if(isset($d['lansia_nama'])) • Lansia: {{ $d['lansia_nama'] }} @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>
