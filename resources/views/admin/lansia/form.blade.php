<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HEALTH SYNC - Input Data Lansia</title>

<style>
body{
    margin:0;
    padding:1.5rem;
    font-family:system-ui, sans-serif;
    background:#f0f9f9;
}
.topbar{
    background:#2A857D;
    color:white;
    padding:1.3rem 2rem;
    border-radius:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.brand{font-size:1.4rem;font-weight:900;}
.wrap{display:flex;justify-content:center;margin-top:2rem;}
.content{
    background:#2A857D;
    border-radius:15px;
    padding:3rem;
    width:100%;
    min-height:calc(100vh - 160px);
    background-image:url('/images/HEALTHSYNC.png');
    background-repeat:no-repeat;
    background-position:center;
    background-size:400px;
    display:flex;
    justify-content:center;
}
.card{
    background:white;
    width:100%;
    max-width:900px;
    padding:2rem 2.2rem;
    border-radius:18px;
    box-shadow:0 4px 15px rgba(0,0,0,0.15);
    margin-bottom:25px;
}
.section-title{
    margin-bottom:1.2rem;
    padding-bottom:.5rem;
    border-bottom:2px solid #e5e7eb;
    font-size:1.3rem;
    font-weight:800;
}
.grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}
label{
    font-weight:650;
    margin-bottom:6px;
    display:block;
}
input, select, textarea{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:10px;
}
textarea{min-height:75px;resize:none;}
.error{
    font-size:.8rem;
    color:#d62828;
    margin-top:4px;
}
.card-buttons{
    background:white;
    width:100%;
    max-width:500px;
    margin:20px auto;
    padding:1.5rem 2rem;
    border-radius:18px;
    display:flex;
    justify-content:center;
}
.button-box{display:flex;gap:20px;}
.btn-save{
    background:#23867F;
    color:white;
    padding:10px 34px;
    border:none;
    border-radius:10px;
    font-weight:700;
    cursor:pointer;
}
.btn-cancel{
    background:#d62828;
    color:white;
    padding:10px 34px;
    border:none;
    border-radius:10px;
    font-weight:700;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="topbar">
    <div class="brand">HEALTH SYNC</div>
    <a href="{{ route('admin.lansia.index') }}"
       style="background:#1f2937;padding:8px 18px;border-radius:10px;color:white;text-decoration:none;">
       Kembali
    </a>
</div>

<div class="wrap">
<main class="content">

<form method="POST" action="{{ route('admin.lansia.store') }}">
@csrf

@php
$oldLansias = old('lansia', [
    ['nama_lansia'=>'','umur'=>'','jenis_kelamin'=>'','alamat'=>'']
]);
@endphp

<!-- ===================== DATA LANSIA ===================== -->
<div id="lansia-wrapper">
@foreach($oldLansias as $i => $l)
<div class="card lansia-card">
    <h3 class="section-title" style="display:flex;justify-content:space-between;align-items:center;">
        <span>Data Lansia {{ $i + 1 }}</span>

        @if($i > 0)
        <button type="button" class="btn-cancel" onclick="hapusLansia(this)">
            Hapus
        </button>
        @endif
    </h3>

    <div class="grid">
        

        <div>
            <label>Nama</label>
            <input name="lansia[{{ $i }}][nama_lansia]"
                   value="{{ old("lansia.$i.nama_lansia") }}" required>
            @error("lansia.$i.nama_lansia")
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Tanggal Lahir</label>
            <input type="date" name="lansia[{{ $i }}][umur]"
                   value="{{ old("lansia.$i.umur") }}" required>
            @error("lansia.$i.umur")
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Jenis Kelamin</label>
            <select name="lansia[{{ $i }}][jenis_kelamin]" required>
                <option value="">Pilih</option>
                <option value="L" {{ old("lansia.$i.jenis_kelamin")=='L'?'selected':'' }}>Laki-laki</option>
                <option value="P" {{ old("lansia.$i.jenis_kelamin")=='P'?'selected':'' }}>Perempuan</option>
            </select>
            @error("lansia.$i.jenis_kelamin")
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <label style="margin-top:16px;">Alamat</label>
    <textarea name="lansia[{{ $i }}][alamat]" required>{{ old("lansia.$i.alamat") }}</textarea>
    @error("lansia.$i.alamat")
        <div class="error">{{ $message }}</div>
    @enderror
</div>
@endforeach
</div>

<!-- TOMBOL TAMBAH -->
<div class="card-buttons">
    <div class="button-box">
        <button type="button" class="btn-save" onclick="tambahLansia()">+ Tambah Lansia</button>
    </div>
</div>

<!-- ===================== AKUN KELUARGA ===================== -->
<div class="card">
    <h3 class="section-title">Akun Keluarga (Opsional)</h3>

    <div class="grid">
        <div><label>Nama</label><input name="keluarga_nama" value="{{ old('keluarga_nama') }}"></div>
        <div><label>Email</label><input type="email" name="keluarga_email" value="{{ old('keluarga_email') }}"></div>
        <div><label>No. Telepon</label><input name="keluarga_no_telepon" value="{{ old('keluarga_no_telepon') }}"></div>
        <div><label>Hubungan</label><input name="keluarga_hubungan" value="{{ old('keluarga_hubungan') }}"></div>
    </div>

    <label style="margin-top:16px;">Alamat</label>
    <input name="keluarga_alamat" value="{{ old('keluarga_alamat') }}">

    <label style="margin-top:16px;">Password Awal</label>
    <input name="keluarga_password" value="{{ old('keluarga_password','123456') }}">
</div>

<!-- SIMPAN -->
<div class="card-buttons">
    <div class="button-box">
        <button class="btn-save" type="submit">Simpan</button>
        <a class="btn-cancel" href="{{ route('admin.lansia.index') }}">Batal</a>
    </div>
</div>

</form>
</main>
</div>

<script>
let indexLansia = {{ count($oldLansias) }};

function tambahLansia(){
    const w = document.getElementById('lansia-wrapper');
    const i = indexLansia;

    w.insertAdjacentHTML('beforeend', `
    <div class="card lansia-card">
        <h3 class="section-title" style="display:flex;justify-content:space-between;align-items:center;">
            <span>Data Lansia ${i+1}</span>
            <button type="button" class="btn-cancel" onclick="hapusLansia(this)">Hapus</button>
        </h3>

        <div class="grid">
            
            <div><label>Nama</label><input name="lansia[${i}][nama_lansia]" required></div>
            <div><label>Tanggal Lahir</label><input type="date" name="lansia[${i}][umur]" required></div>
            <div>
                <label>Jenis Kelamin</label>
                <select name="lansia[${i}][jenis_kelamin]" required>
                    <option value="">Pilih</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
        </div>

        <label style="margin-top:16px;">Alamat</label>
        <textarea name="lansia[${i}][alamat]" required></textarea>
    </div>
    `);

    indexLansia++;
}

function hapusLansia(btn){
    btn.closest('.lansia-card').remove();
}
</script>

</body>
</html>
