<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode==='create' ? 'Tambah' : 'Edit' }} Instruksi Obat</title>
    <style>
        body { margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto; background:#ffffff; }
        .topbar { background:#1f8a8a; color:#fff; padding:.6rem 1rem; border:3px solid #0f172a; display:flex; align-items:center; justify-content:space-between; }
        .brand { font-weight:900; letter-spacing:.8px; font-size:1.35rem; }
        .nav { display:flex; gap:1.25rem; align-items:center; }
        .nav a { color:#fff; text-decoration:none; font-weight:700; font-size:.9rem; }
        .wrap { display:flex; }
        .sidebar { width:220px; min-height: calc(100vh - 52px); background:#247e81; padding: .75rem; border-right: 2px solid #0f172a; }
        .side-btn { display:block; width:100%; background:#fff; color:#111827; padding:.55rem .7rem; border-radius:18px; font-weight:800; margin:.7rem 0; text-align:left; border:2px solid #0f172a; box-shadow:0 2px 0 rgba(0,0,0,.2); }
        .content { flex:1; padding:1.25rem; }
        .form-wrap { max-width: 720px; background:#f9fafb; border: 2px solid #d1d5db; border-radius:10px; padding:1.5rem; }
        label { display:block; font-weight:700; margin:.6rem 0 .3rem; }
        select, input, textarea { width:100%; padding:.55rem .7rem; border:1px solid #d1d5db; border-radius:8px; }
        .row { display:flex; gap:1rem; }
        .actions { margin-top:1rem; display:flex; gap:.6rem; }
        a.btn, button.btn { background:#1f2937; color:#fff; padding:.5rem .8rem; border-radius:8px; text-decoration:none; border:none; cursor:pointer; }
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
            <a class="side-btn" href="{{ route('medis.instruksi.index') }}">Instruksi Obat</a>
        </aside>
        <main class="content">
            <div class="form-wrap">
                <h2 style="margin:0 0 1rem;">{{ $mode==='create' ? 'Tambah' : 'Edit' }} Instruksi Obat</h2>

                @if ($errors->any())
                    <div style="background:#fee2e2;border:1px solid #ef4444;padding:.6rem;border-radius:8px;margin-bottom:.8rem;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ $mode==='create' ? route('medis.instruksi.store') : route('medis.instruksi.update', $item) }}">
                    @csrf
                    @if($mode==='edit') @method('PUT') @endif

                    <label for="lansia_id">Lansia <span style="color:#dc2626;">*</span></label>
                    <select id="lansia_id" name="lansia_id" required>
                        @foreach ($lansia as $l)
                            <option value="{{ $l->id }}" @selected(old('lansia_id', $item->lansia_id) == $l->id)>{{ $l->nama_lansia }} ({{ $l->id_lansia }})</option>
                        @endforeach
                    </select>

                    <label for="nama_obat">Nama Obat <span style="color:#dc2626;">*</span></label>
                    <input id="nama_obat" type="text" name="nama_obat" value="{{ old('nama_obat', $item->nama_obat) }}" required placeholder="Contoh: Amlodipine, Paracetamol, dll" />

                    <div class="row">
                        <div style="flex:1;">
                            <label for="dosis">Dosis</label>
                            <input id="dosis" type="text" name="dosis" value="{{ old('dosis', $item->dosis) }}" placeholder="Contoh: 5mg, 500mg, dll" />
                        </div>
                        <div style="flex:1;">
                            <label for="frekuensi">Frekuensi</label>
                            <input id="frekuensi" type="text" name="frekuensi" value="{{ old('frekuensi', $item->frekuensi) }}" placeholder="Contoh: 1x sehari, 3x sehari, dll" />
                        </div>
                    </div>

                    <div class="row">
                        <div style="flex:1;">
                            <label for="mulai_pada">Mulai Pada</label>
                            <input id="mulai_pada" type="date" name="mulai_pada" value="{{ old('mulai_pada', $item->mulai_pada?->format('Y-m-d')) }}" />
                        </div>
                        <div style="flex:1;">
                            <label for="selesai_pada">Selesai Pada</label>
                            <input id="selesai_pada" type="date" name="selesai_pada" value="{{ old('selesai_pada', $item->selesai_pada?->format('Y-m-d')) }}" />
                        </div>
                    </div>

                    <label for="status">Status</label>
                    <select id="status" name="status">
                        @foreach (['aktif','selesai','ditunda'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $item->status ?? 'aktif') == $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>

                    <label for="catatan">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="4" placeholder="Catatan tambahan tentang instruksi obat...">{{ old('catatan', $item->catatan) }}</textarea>

                    <div class="actions">
                        <button class="btn" type="submit">Simpan</button>
                        <a class="btn" href="{{ route('medis.instruksi.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

