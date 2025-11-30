<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background: #E5E5E5;
        padding-bottom: 90px;
    }

    /* HEADER */
    .header {
        background:#2A857D;
        color:white;
        padding:16px;
        text-align:center;
        font-size:1.25rem;
        font-weight:700;
    }

    /* MAIN BACKGROUND WITH LOGO WATERMARK */
    .bg-green {
        background:#1E7F77;
        width:100%;
        padding-top:35px;     /* ⭐ TURUNKAN LEBIH JAUH */
        padding-bottom:60px;  /* ⭐ TAMBAHKAN RUANG BAWAH */
        min-height: calc(100vh - 130px);

        /* BACKGROUND LOGO KABUR */
        background-image: url('/images/HEALTHSYNC.png');
        background-repeat: no-repeat;
        background-position: center 250px;
        background-size: 240px;
        opacity: 0.97;
    }

    /* Blur filter for background image only */
    .bg-green::before {
        content:"";
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-image: url('/images/HEALTHSYNC.png');
        background-size:260px;
        background-repeat:no-repeat;
        background-position:center 80px;
        opacity:0.08;         /* ⭐ Transparansi logo */
        filter: blur(4px);    /* ⭐ Blur lembut */
        z-index:0;
    }

    .container {
        width:360px;
        max-width:calc(100% - 20px);
        margin:auto;
        position:relative;
        z-index:5;   /* supaya card menutupi blur logo */
    }

    /* KONDISI DARURAT FULL WIDTH */
    .btn-danger {
        width:100%;
        padding:18px;
        text-align:center;
        background:white;
        border:none;
        border-radius:16px;
        color:#C62828;
        font-weight:bold;
        box-shadow:0 4px 8px rgba(0,0,0,0.25);
        cursor:pointer;
        margin-bottom:40px;  /* ⭐ TURUNKAN JAUH */
        font-size:1rem;
    }

    /* SECTION TITLE */
    .section-title {
        color:white;
        font-weight:700;
        font-size:1rem;
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-top:35px;   /* ⭐ TURUN 35px */
        margin-bottom:14px;
    }

    .icon {
        width:22px;
        height:22px;
        background-size:contain;
        background-repeat:no-repeat;
        display:inline-block;
        cursor:pointer;
    }

    .icon-plus {
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' stroke='%23FFFFFF' fill='none' viewBox='0 0 24 24'%3E%3Cpath d='M12 4v16m8-8H4' stroke-width='2'/%3E%3C/svg%3E");
    }

    .icon-check {
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' stroke='%23FFFFFF' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke-width='2' stroke-linecap='round' stroke-linejoin='round' d='M9 5h6m5 4H4m5 4h6m5 4H4'/%3E%3C/svg%3E");
    }

    .icon-link { text-decoration:none; }

    /* CARD / BOX */
    .box {
        background:white;
        padding:16px;
        border-radius:16px;
        margin-bottom:32px;  /* ⭐ CARD LEBIH JAUH */
        box-shadow:0 4px 8px rgba(0,0,0,0.22);
        font-size:0.95rem;
    }

    .box-link {
        text-decoration:none;
        color:black;
        display:block;
    }

    .lansia-item {
        background:#F9FAFB;
        padding:12px;
        border-radius:10px;
        margin-bottom:10px;
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
        padding:6px 10px;
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
        border-right:1px solid #EEE;
        text-decoration:none;
        color:black;
    }

    .nav-item:last-child { border-right:none; }
    .nav-item.active { color:#2A857D; font-weight:bold; }

    .box-soft,
    .box-soft * {
        font-weight: 300;
        color: #6b6b6b;
        opacity: 0.85;
    }



</style>
</head>

<body>

<div class="header">HEALTH SYNC</div>

<div class="bg-green">
    <div class="container">

        <!-- KONDISI DARURAT -->
        <form action="{{ route('pengasuh.kirim-notifikasi-darurat-langsung') }}" method="POST">
            @csrf
            <button type="submit" class="btn-danger">🚨 KONDISI DARURAT</button>
        </form>

        <!-- RIWAYAT -->
        <div class="section-title">
            <span>RIWAYAT KONDISI LANSIA</span>
            <a href="{{ route('pengasuh.riwayat') }}" class="icon-link"><span class="icon icon-check"></span></a>
        </div>

        <a class="box box-link" href="{{ route('pengasuh.riwayat') }}">
            @foreach($lansia as $l)
            <div class="lansia-item"><strong>{{ $l->nama_lansia }}</strong> ({{ $l->id_lansia }})</div>
            @endforeach
        </a>

        <!-- JADWAL -->
        <div class="section-title">
            <span>LIHAT KEGIATAN LANSIA</span>
            <a href="{{ route('pengasuh.kegiatan-lansia.index') }}" class="icon-link"><span class="icon icon-plus"></span></a>
        </div>

        <a class="box box-link box-soft" href="{{ route('pengasuh.kegiatan-lansia.index') }}">
            Klik icon ini untuk melihat jadwal kegiatan lansia
        </a>


        <!-- TAMBAH -->
        <div class="section-title">
            <span>TAMBAH KONDISI LANSIA</span>
            <a href="{{ route('pengasuh.update-kondisi') }}" class="icon-link"><span class="icon icon-plus"></span></a>
        </div>

        <a class="box box-link box-soft" href="{{ route('pengasuh.update-kondisi') }}">
            Klik icon ini untuk menambah kondisi lansia
        </a>


    </div>
</div>

<!-- NAVIGATION BAR -->
<div class="bottom-nav">
    <div class="nav-inner">

        <!-- HOME -->
        <a href="{{ route('pengasuh.dashboard') }}" class="nav-item active">
            <svg width="22" height="22" viewBox="0 0 24 24" stroke="#2A857D" fill="none" stroke-width="2">
                <path d="M3 12l9-9 9 9"/>
                <path d="M9 21V12h6v9"/>
            </svg>
            <br>Home
        </a>

        <!-- NOTIFIKASI -->
        <a href="#" class="nav-item">
            <svg width="22" height="22" viewBox="0 0 24 24" stroke="#2A857D" fill="none" stroke-width="2">
                <path d="M15 17h5l-1.4-1.4c-.4-.8-.6-1.2-.6-1.6V11c0-3.3-2.2-6-5-6s-5 2.7-5 6v3c0 .4-.2.8-.6 1.6L6 17h5"/>
                <path d="M14 17v1a2 2 0 1 1-4 0v-1"/>
            </svg>
            <br>Notifikasi
        </a>

        <!-- PROFILE -->
        <a href="#" class="nav-item">
            <svg width="22" height="22" viewBox="0 0 24 24" stroke="#2A857D" fill="none" stroke-width="2">
                <circle cx="12" cy="8" r="4"/>
                <path d="M6 20v-1c0-3.3 2.7-5 6-5s6 1.7 6 5v1"/>
            </svg>
            <br>Profile
        </a>

    </div>
</div>


</body>
</html>
