<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Tambah Lansia & Akun Keluarga</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f6f7fb;margin:0}
        .topbar{background:#0d6b6b;color:#fff;padding:14px 16px;display:flex;justify-content:space-between;align-items:center}
        .container{padding:16px}
        .card{background:#fff;border-radius:12px;padding:14px;margin-bottom:12px;box-shadow:0 2px 6px rgba(0,0,0,0.06)}
        .grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
        label{display:block;font-weight:600;margin-bottom:6px}
        input,select,textarea{width:100%;padding:10px;border:1px solid #ddd;border-radius:8px}
        .btn{background:#0d6b6b;color:#fff;border:none;border-radius:8px;padding:10px 14px;cursor:pointer}
        .error{color:#b00020;font-size:12px}
    </style>
</head>
<body>
<div class="topbar">
    <div>HEALTH SYNC</div>
    <div>
        <a href="{{ route('admin.lansia.index') }}" class="btn" style="background:#245b5b">Kembali</a>
    </div>
</div>

<div class="container">
    <form method="POST" action="{{ route('admin.lansia.store') }}">
        @csrf
        <div class="card">
            <h3>Data Lansia</h3>
            <div class="grid">
                <div>
                    <label>ID Lansia</label>
                    <input name="id_lansia" value="{{ old('id_lansia') }}" required>
                    @error('id_lansia')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>Nama</label>
                    <input name="nama_lansia" value="{{ old('nama_lansia') }}" required>
                    @error('nama_lansia')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>Tanggal Lahir</label>
                    <input type="date" name="umur" value="{{ old('umur') }}">
                    @error('umur')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin">
                        <option value="">-</option>
                        <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>L</option>
                        <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>P</option>
                    </select>
                    @error('jenis_kelamin')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="margin-top:12px;">
                <label>Alamat</label>
                <textarea name="alamat">{{ old('alamat') }}</textarea>
                @error('alamat')<div class="error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="card">
            <h3>Akun Keluarga (opsional)</h3>
            <div class="grid">
                <div>
                    <label>Nama</label>
                    <input name="keluarga_nama" value="{{ old('keluarga_nama') }}">
                    @error('keluarga_nama')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="keluarga_email" value="{{ old('keluarga_email') }}">
                    @error('keluarga_email')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>No. Telepon</label>
                    <input name="keluarga_no_telepon" value="{{ old('keluarga_no_telepon') }}">
                    @error('keluarga_no_telepon')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>Hubungan</label>
                    <input name="keluarga_hubungan" value="{{ old('keluarga_hubungan') }}">
                    @error('keluarga_hubungan')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="grid" style="margin-top:12px;">
                <div>
                    <label>Alamat</label>
                    <input name="keluarga_alamat" value="{{ old('keluarga_alamat') }}">
                    @error('keluarga_alamat')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label>Password Awal</label>
                    <input type="text" name="keluarga_password" value="{{ old('keluarga_password','123456') }}">
                    @error('keluarga_password')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn">Simpan</button>
    </form>
</div>
</body>
</html>
