<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode==='create' ? 'Tambah' : 'Edit' }} Jadwal Kegiatan</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto; margin:0; background:#f8fafc; }
        .wrap { max-width: 720px; margin: 2rem auto; background:#fff; border-radius:12px; box-shadow: 0 8px 24px rgba(0,0,0,.06); padding:1rem; }
        label { display:block; font-weight:700; margin:.6rem 0 .3rem; }
        select, input, textarea { width:100%; padding:.55rem .7rem; border:1px solid #d1d5db; border-radius:8px; }
        .row { display:flex; gap:1rem; }
        .actions { margin-top:1rem; display:flex; gap:.6rem; }
        a.btn, button.btn { background:#1f2937; color:#fff; padding:.5rem .8rem; border-radius:8px; text-decoration:none; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <div class="wrap">
        <h2 style="margin:0 0 1rem;">{{ $mode==='create' ? 'Tambah' : 'Edit' }} Jadwal Kegiatan</h2>

        @if ($errors->any())
            <div style="background:#fee2e2;border:1px solid #ef4444;padding:.6rem;border-radius:8px;margin-bottom:.8rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ $mode==='create' ? route('admin.jadwal.store') : route('admin.jadwal.update', $item) }}">
            @csrf
            @if($mode==='edit') @method('PUT') @endif

            @if($mode==='edit' && $item->id_jadwal)
                <label for="id_jadwal">ID Jadwal</label>
                <input id="id_jadwal" type="text" value="{{ $item->id_jadwal }}" readonly style="background:#f3f4f6;" />
            @endif

            <label for="lansia_id">Lansia</label>
            <select id="lansia_id" name="lansia_id" required>
                @foreach ($lansia as $l)
                    <option value="{{ $l->id }}" @selected(old('lansia_id', $item->lansia_id) == $l->id)>{{ $l->nama_lansia }} ({{ $l->id_lansia }})</option>
                @endforeach
            </select>

            <div class="row">
                <div style="flex:1;">
                    <label for="tanggal">Tanggal</label>
                    <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', $item->tanggal?->format('Y-m-d')) }}" required />
                </div>
                <div style="flex:1;">
                    <label for="waktu">Waktu</label>
                    <input id="waktu" type="time" name="waktu" value="{{ old('waktu', $item->waktu) }}" required />
                </div>
            </div>

            <label for="aktivitas">Aktivitas</label>
            <input id="aktivitas" type="text" name="aktivitas" value="{{ old('aktivitas', $item->aktivitas) }}" required placeholder="Contoh: Senam pagi, Konsultasi, dll" />

            <label for="medis_user_id">Tenaga Medis (Opsional)</label>
            <select id="medis_user_id" name="medis_user_id">
                <option value="">-- Pilih Tenaga Medis --</option>
                @foreach ($medis as $m)
                    <option value="{{ $m->id }}" @selected(old('medis_user_id', $item->medis_user_id) == $m->id)>{{ $m->name }}</option>
                @endforeach
            </select>

            <label for="lokasi">Lokasi (Opsional)</label>
            <input id="lokasi" type="text" name="lokasi" value="{{ old('lokasi', $item->lokasi) }}" />

            <label for="catatan">Catatan (Opsional)</label>
            <textarea id="catatan" name="catatan" rows="4">{{ old('catatan', $item->catatan) }}</textarea>

            <div class="actions">
                <button class="btn" type="submit">Simpan</button>
                <a class="btn" href="{{ route('admin.jadwal.index') }}">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>


