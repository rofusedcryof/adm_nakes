<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HEALTH SYNC - Input Data Lansia</title>

<style>
/* ===================== GLOBAL ===================== */
body{
    margin:0;
    padding:1.5rem;
    font-family:system-ui, sans-serif;
    background:#f0f9f9;
}

/* ===================== TOPBAR ===================== */
.topbar{
    background:#2A857D;
    color:white;
    padding:1.3rem 2rem;
    border-radius:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 3px 8px rgba(0,0,0,0.1);
}

.brand{
    font-size:1.4rem;
    font-weight:900;
}

/* ===================== CONTENT WRAPPER ===================== */
.wrap{
    width:100%;
    display:flex;
    justify-content:center;
    margin-top:2rem;
}

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

/* ===================== CARD ===================== */
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

/* ===================== FORM ===================== */
.grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

label{
    font-weight:650;
    margin-bottom:6px;
    display:block;
    font-size:.92rem;
}

input, select, textarea{
    width:100%;
    padding:12px;
    font-size:.95rem;
    border:1px solid #ccc;
    border-radius:10px;
    transition:.2s;
}

input:focus, select:focus, textarea:focus{
    border-color:#2A857D;
    outline:none;
    box-shadow:0 0 0 3px rgba(42,133,125,0.25);
}

textarea{
    min-height:75px;
    resize:none;
}

.error{
    font-size:.8rem;
    color:#d62828;
    margin-top:4px;
}

/* ===================== CARD TOMBOL ===================== */
.card-buttons{
    background:white;
    width:100%;
    max-width:500px; 
    margin:20px auto; 
    padding:1.5rem 2rem;
    border-radius:18px;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
    display:flex;
    justify-content:center;
}

/* WRAP BUTTON */
.button-box{
    display:flex;
    gap:20px;
}

/* TOMBOL SIMPAN */
.btn-save{
    background:#23867F;
    padding:10px 34px;
    color:white;
    border:none;
    font-weight:700;
    border-radius:10px;
    cursor:pointer;
    font-size:.95rem;
    transition:.2s;
}

.btn-save:hover{
    background:#1b6c65;
}

/* TOMBOL BATAL */
.btn-cancel{
    background:#d62828;
    padding:10px 34px;
    color:white;
    border:none;
    font-weight:700;
    border-radius:10px;
    cursor:pointer;
    font-size:.95rem;
    text-decoration:none;
    transition:.2s;
}

.btn-cancel:hover{
    background:#b71f1f;
}
</style>
</head>

<body>

<!-- ===================== NAVBAR ===================== -->
<div class="topbar">
    <div class="brand">HEALTH SYNC</div>

    <a href="{{ route('admin.lansia.index') }}" 
       style="background:#1f2937;padding:8px 18px;border-radius:10px;color:white;font-weight:700;text-decoration:none;">
       Kembali
    </a>
</div>

<!-- ===================== CONTENT ===================== -->
<div class="wrap">
    <main class="content">

        <form method="POST" action="{{ route('admin.lansia.store') }}">
        @csrf

            <!-- ===================== DATA LANSIA ===================== -->
            <div class="card">
                <h3 class="section-title">Data Lansia</h3>

                <div class="grid">
                    <div>
                        <label>ID Lansia</label>
                        <input name="id_lansia" required>
                    </div>

                    <div>
                        <label>Nama</label>
                        <input name="nama_lansia" required>
                    </div>

                    <div>
                        <label>Tanggal Lahir</label>
                        <input type="date" name="umur">
                    </div>

                    <div>
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="">Pilih</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>

                <label style="margin-top:16px;">Alamat</label>
                <textarea name="alamat"></textarea>
            </div>

            <!-- ===================== AKUN KELUARGA ===================== -->
            <div class="card">
                <h3 class="section-title">Akun Keluarga (Opsional)</h3>

                <div class="grid">
                    <div>
                        <label>Nama</label>
                        <input name="keluarga_nama">
                    </div>

                    <div>
                        <label>Email</label>
                        <input type="email" name="keluarga_email">
                    </div>

                    <div>
                        <label>No. Telepon</label>
                        <input name="keluarga_no_telepon">
                    </div>

                    <div>
                        <label>Hubungan</label>
                        <input name="keluarga_hubungan">
                    </div>
                </div>

                <label style="margin-top:16px;">Alamat</label>
                <input name="keluarga_alamat">

                <label style="margin-top:16px;">Password Awal</label>
                <input name="keluarga_password" value="123456">
            </div>

            <!-- ===================== CARD TOMBOL ===================== -->
            <div class="card-buttons">
                <div class="button-box">
                    <button class="btn-save" type="submit">Simpan</button>
                    <a class="btn-cancel" href="{{ route('admin.lansia.index') }}">Batal</a>
                </div>
            </div>

        </form>

    </main>
</div>

</body>
</html>
