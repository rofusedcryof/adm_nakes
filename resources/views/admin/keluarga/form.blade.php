<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode==='create' ? 'Tambah' : 'Edit' }} Keluarga</title>
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
        <h2 style="margin:0 0 1rem;">{{ $mode==='create' ? 'Tambah' : 'Edit' }} Data Keluarga</h2>

        @if ($errors->any())
            <div style="background:#fee2e2;border:1px solid #ef4444;padding:.6rem;border-radius:8px;margin-bottom:.8rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ $mode==='create' ? route('admin.keluarga.store') : route('admin.keluarga.update', $item) }}">
            @csrf
            @if($mode==='edit') @method('PUT') @endif

            <label for="nama">Nama <span style="color:#dc2626;">*</span></label>
            <input id="nama" type="text" name="nama" value="{{ old('nama', $item->nama) }}" required />

            <label for="email">Email <span style="color:#dc2626;">*</span></label>
            <input id="email" type="email" name="email" value="{{ old('email', $item->email) }}" required />

            <label for="no_telepon">No. Telepon <span style="color:#dc2626;">*</span></label>
            <input id="no_telepon" type="tel" name="no_telepon" value="{{ old('no_telepon', $item->no_telepon) }}" required placeholder="Contoh: 08123456789" maxlength="20" />

            <label for="alamat">Alamat <span style="color:#dc2626;">*</span></label>
            <textarea id="alamat" name="alamat" rows="3" required>{{ old('alamat', $item->alamat) }}</textarea>

            <div class="row">
                <div style="flex:1;">
                    <label for="hubungan">Hubungan <span style="color:#dc2626;">*</span></label>
                    <select id="hubungan" name="hubungan" required>
                        <option value="">-- Pilih Hubungan --</option>
                        @foreach (['anak', 'menantu', 'cucu', 'saudara', 'lainnya'] as $h)
                            <option value="{{ $h }}" @selected(old('hubungan', $item->hubungan) == $h)>{{ ucfirst($h) }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex:1;">
                    <label for="lansia_id">Lansia <span style="color:#dc2626;">*</span></label>
                    <select id="lansia_id" name="lansia_id" required>
                        <option value="">-- Pilih Lansia --</option>
                        @foreach ($lansia as $l)
                            <option value="{{ $l->id }}" @selected(old('lansia_id', $item->lansia_id) == $l->id)>{{ $l->nama_lansia }} ({{ $l->id_lansia }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="actions">
                <button class="btn" type="submit">Simpan</button>
                <a class="btn" href="{{ route('admin.keluarga.index') }}">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>

