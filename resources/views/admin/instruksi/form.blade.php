<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode==='create' ? 'Tambah' : 'Edit' }} Instruksi Obat</title>
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
        <h2 style="margin:0 0 1rem;">{{ $mode==='create' ? 'Tambah' : 'Edit' }} Instruksi Obat</h2>

        @if ($errors->any())
            <div style="background:#fee2e2;border:1px solid #ef4444;padding:.6rem;border-radius:8px;margin-bottom:.8rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ $mode==='create' ? route('admin.instruksi.store') : route('admin.instruksi.update', $item) }}">
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

            <label for="medis_user_id">Tenaga Medis (Opsional)</label>
            <select id="medis_user_id" name="medis_user_id">
                <option value="">-- Pilih Tenaga Medis --</option>
                @foreach ($medis as $m)
                    <option value="{{ $m->id }}" @selected(old('medis_user_id', $item->medis_user_id) == $m->id)>{{ $m->name }}</option>
                @endforeach
            </select>

            <label for="catatan">Catatan</label>
            <textarea id="catatan" name="catatan" rows="4" placeholder="Catatan tambahan tentang instruksi obat...">{{ old('catatan', $item->catatan) }}</textarea>

            <div class="actions">
                <button class="btn" type="submit">Simpan</button>
                <a class="btn" href="{{ route('admin.instruksi.index') }}">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>

