<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Tambah Kondisi Lansia</title>

<style>
    * { margin:0; padding:0; box-sizing:border-box; }

    body {
        font-family:Arial, sans-serif;
        background:#1E7F77;
        min-height:100vh;
        padding-bottom:120px;
        position:relative;
    }

    body::before {
        content:"";
        position:absolute;
        top:50%; left:50%;
        width:260px; height:260px;
        transform:translate(-50%, -50%);
        background:url('/images/HEALTHSYNC.png') no-repeat center;
        background-size:230px;
        opacity:0.12;
        z-index:0;
    }

    .header {
        background:#2A857D;
        color:white;
        padding:16px;
        text-align:center;
        font-size:1.25rem;
        font-weight:700;
        position:relative;
        z-index:5;
    }

    .back-btn {
        position:absolute;
        left:16px; top:50%;
        transform:translateY(-50%);
        background:none;
        border:none;
        color:white;
        font-size:1.4rem;
        cursor:pointer;
    }

    .container {
        width:360px;
        max-width:calc(100% - 20px);
        margin:auto;
        margin-top:16px;
        position:relative;
        z-index:5;
    }

    .form-card {
        background:white;
        padding:18px;
        border-radius:16px;
        box-shadow:0 4px 10px rgba(0,0,0,0.25);
    }

    label {
        font-weight:600;
        font-size:0.95rem;
        margin-bottom:4px;
        display:block;
    }

    .required { color:#D32F2F; }

    input, select, textarea {
        width:100%;
        padding:12px;
        border:1px solid #D1D5DB;
        border-radius:10px;
        margin-top:6px;
        font-size:1rem;
    }

    input:focus, select:focus, textarea:focus {
        border-color:#2A857D;
        box-shadow:0 0 0 3px rgba(42,133,125,0.2);
        outline:none;
    }

    .row {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:1rem;
    }

    .btn-submit {
        background:#2A857D;
        color:white;
        padding:14px;
        border:none;
        border-radius:12px;
        font-size:1rem;
        font-weight:700;
        cursor:pointer;
        width:100%;
        transition:0.25s;
    }

    .btn-cancel {
        background:#D9534F;
        color:white;
        padding:14px;
        border:none;
        border-radius:12px;
        font-size:1rem;
        font-weight:700;
        cursor:pointer;
        width:100%;
        margin-top:8px;
    }

    /* POPUP */
    .popup-overlay {
        position:fixed;
        top:0; left:0;
        width:100%; height:100%;
        background:rgba(0,0,0,0.45);
        display:flex;
        justify-content:center;
        align-items:center;
        z-index:2000;
        backdrop-filter:blur(2px);
    }

    .popup-box {
        background:white;
        padding:20px;
        border-radius:16px;
        width:300px;
        text-align:center;
        box-shadow:0 4px 20px rgba(0,0,0,0.3);
        animation:fadeZoom 0.3s ease;
    }

    @keyframes fadeZoom {
        from { opacity:0; transform:scale(0.8); }
        to { opacity:1; transform:scale(1); }
    }

    .popup-ok {
        margin-top:14px;
        background:#2A857D;
        color:white;
        padding:10px 20px;
        border:none;
        border-radius:10px;
        font-weight:bold;
        cursor:pointer;
        width:100%;
    }

    /* NAVBAR */
    .bottom-nav {
        position:fixed;
        bottom:0;
        left:50%;
        transform:translateX(-50%);
        width:420px;
        max-width:100%;
        background:#2A857D;
        padding:8px 10px;
        z-index:10;
    }

    .nav-inner {
        background:white;
        display:flex;
        border-radius:12px;
        overflow:hidden;
    }

    .nav-item {
        flex:1;
        text-align:center;
        padding:10px 0;
        font-size:0.78rem;
        color:black;
        text-decoration:none;
        border-right:1px solid #EEE;
    }

    .nav-item.active { color:#2A857D; font-weight:bold; }

    .nav-item:last-child { border-right:none; }

    .nav-icon {
        width:22px;
        height:22px;
        background-size:contain;
        background-repeat:no-repeat;
        margin-bottom:2px;
        display:inline-block;
    }

    .icon-home {
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' stroke='%232A857D' fill='none' viewBox='0 0 24 24'%3E%3Cpath d='M3 12l9-9 9 9' stroke-width='2'/%3E%3Cpath d='M9 21V12h6v9' stroke-width='2'/%3E%3C/svg%3E");
    }

    .icon-bell {
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' stroke='%232A857D' fill='none' viewBox='0 0 24 24'%3E%3Cpath d='M15 17h5l-1.405-1.405C18.21 14.79 18 14.42 18 14V11c0-3.314-2.239-6-5-6S8 7.686 8 11v3c0 .42-.21.79-.595 1.595L6 17h5' stroke-width='2'/%3E%3Cpath d='M14 17v1a2 2 0 11-4 0v-1' stroke-width='2'/%3E%3C/svg%3E");
    }

    .icon-user {
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' stroke='%232A857D' fill='none' viewBox='0 0 24 24'%3E%3Ccircle cx='12' cy='8' r='4'/%3E%3Cpath d='M6 20v-1c0-3 3-5 6-5s6 2 6 5v1' stroke-width='2'/%3E%3C/svg%3E");
    }

</style>
</head>

<body>

<!-- POPUP -->
@if(session('success'))
<div class="popup-overlay" id="popupSuccess">
    <div class="popup-box">
        <div style="font-weight:bold; color:#2A857D; font-size:1rem;">
            {{ session('success') }}
        </div>
        <button class="popup-ok" onclick="document.getElementById('popupSuccess').remove();">
            OK
        </button>
    </div>
</div>
@endif

<div class="header">
    <button class="back-btn" onclick="window.history.back()">←</button>
    TAMBAH KONDISI LANSIA
</div>

<div class="container">

    <form action="{{ route('pengasuh.update-kondisi.store') }}" method="POST" class="form-card">
        @csrf

        <label>Lansia <span class="required">*</span></label>
        <select name="lansia_id" required>
            <option value="">-- Pilih Lansia --</option>
            @foreach($lansia as $l)
                <option value="{{ $l->id }}">{{ $l->nama_lansia }} ({{ $l->id_lansia }})</option>
            @endforeach
        </select>

        <div class="row" style="margin-top:12px;">
            <div>
                <label>Tanggal <span class="required">*</span></label>
                <input type="date" name="tanggal" required>
            </div>
            <div>
                <label>Waktu <span class="required">*</span></label>
                <input type="time" name="waktu" required>
            </div>
        </div>

        <div class="row" style="margin-top:12px;">
            <div>
                <label>Sistol (mmHg)</label>
                <input type="number" name="sistol" placeholder="120">
            </div>
            <div>
                <label>Diastol (mmHg)</label>
                <input type="number" name="diastol" placeholder="80">
            </div>
        </div>

        <div class="row" style="margin-top:12px;">
            <div>
                <label>Nadi (bpm)</label>
                <input type="number" name="nadi" placeholder="72">
            </div>
            <div>
                <label>Suhu (°C)</label>
                <input type="number" step="0.1" name="suhu" placeholder="36.5">
            </div>
        </div>

        <label style="margin-top:12px;">Gula Darah (mg/dL)</label>
        <input type="number" name="gula_darah" placeholder="100">

        <label style="margin-top:12px;">Catatan</label>
        <textarea name="catatan" rows="4" placeholder="Catatan tambahan..."></textarea>

        <button class="btn-submit">Simpan</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('pengasuh.dashboard') }}'">Batal</button>

    </form>

</div>

<!-- NAVBAR -->
<div class="bottom-nav">
    <div class="nav-inner">

        <a href="{{ route('pengasuh.dashboard') }}" class="nav-item active">
            <span class="nav-icon icon-home"></span><br>Home
        </a>

        <a href="#" class="nav-item">
            <span class="nav-icon icon-bell"></span><br>Notifikasi
        </a>

        <a href="#" class="nav-item">
            <span class="nav-icon icon-user"></span><br>Profile
        </a>

    </div>
</div>

</body>
</html>
