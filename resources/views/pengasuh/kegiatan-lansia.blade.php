<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HEALTH SYNC - Jadwal Kegiatan Lansia</title>

<style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:Arial, sans-serif; }

    body {
        background:#E5E5E5;
        padding-bottom:90px;
    }

    /* HEADER */
    .header-top {
        background:#2A857D;
        color:white;
        padding:16px;
        text-align:center;
        font-size:1.25rem;
        font-weight:700;
        position:relative;
    }

    .back-btn {
        position:absolute;
        left:16px;
        top:50%;
        transform:translateY(-50%);
        background:none;
        border:none;
        color:white;
        font-size:1.4rem;
        cursor:pointer;
    }

    /* BACKGROUND */
    .bg-green {
        background:#1E7F77;
        width:100%;
        padding-top:35px;
        padding-bottom:60px;
        min-height:calc(100vh - 130px);
        position:relative;
    }

    .bg-green::before {
        content:"";
        position:absolute;
        top:0; left:0;
        width:100%; height:100%;
        background:url('/images/HEALTHSYNC.png') no-repeat center 180px;
        background-size:240px;
        opacity:0.12;
        filter:blur(1px);
        z-index:0;
    }

    .container {
        width:360px;
        max-width:calc(100% - 20px);
        margin:auto;
        position:relative;
        z-index:5;
    }

    /* CARD */
    .card {
        background:white;
        border-radius:16px;
        padding:18px;
        margin-bottom:20px;
        box-shadow:0 4px 10px rgba(0,0,0,0.22);
    }

    .header-label {
        font-weight:bold;
        font-size:1rem;
        color:#2A857D;
        margin-bottom:14px;
    }

    /* TOMBOL SEMUA LANSIA */
    .btn-all {
        background:#2A857D;
        padding:10px 18px;
        border-radius:25px;
        color:white;
        font-size:0.88rem;
        font-weight:bold;
        text-decoration:none;
        display:inline-block;
        margin-bottom:12px;
        box-shadow:0 3px 8px rgba(0,0,0,0.25);
        transition:0.2s;
    }

    .btn-all:hover {
        background:#257068;
        transform:translateY(-2px);
    }

    /* LIST LANSIA */
    .list-item {
        background:#F8FAFC;
        padding:12px;
        border-radius:12px;
        margin-top:10px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        border:1px solid #E5E7EB;
    }

    .btn-secondary {
        background:#0EA5A4;
        padding:8px 14px;
        border-radius:10px;
        color:white;
        text-decoration:none;
        font-size:0.9rem;
        font-weight:bold;
    }

    /* TABLE */
    table {
        width:100%;
        border-collapse:collapse;
        margin-top:10px;
    }

    th {
        background:#E5E7EB;
        padding:10px;
        color:#2A857D;
        font-size:0.9rem;
        text-align:left;
    }

    td {
        padding:10px;
        border-bottom:1px solid #EEE;
        font-size:0.9rem;
    }

    .empty {
        text-align:center;
        color:#777;
        padding:20px 0;
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
        padding:10px 0;
        text-align:center;
        color:black;
        text-decoration:none;
        border-right:1px solid #EEE;
        font-size:0.78rem;
    }

    .nav-item:last-child { border-right:none; }
    .nav-item.active { color:#2A857D; font-weight:bold; }

    .nav-icon {
        width:22px;
        height:22px;
        margin-bottom:2px;
        display:inline-block;
        background-size:contain;
        background-repeat:no-repeat;
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

<!-- HEADER -->
<div class="header-top">
    <button class="back-btn" onclick="window.history.back()">←</button>
    JADWAL KEGIATAN LANSIA
</div>

<div class="bg-green">
    <div class="container">

        <!-- LANSIA LIST + TOMBOL SEMUA LANSIA -->
        <div class="card">

            <div class="header-label">Jadwal Kegiatan Lansia</div>

            <!-- TOMBOL SEMUA LANSIA (PENTING) -->
            <a href="{{ route('pengasuh.kegiatan-lansia.index') }}" class="btn-all">Semua Lansia</a>

            @foreach($allLansia as $item)
                <div class="list-item">
                    <div>{{ $item->nama_lansia }} ({{ $item->id_lansia }})</div>
                    <a href="{{ route('pengasuh.kegiatan-lansia.show', $item->id_lansia) }}" class="btn-secondary">Lihat</a>
                </div>
            @endforeach

        </div>

        <!-- JADWAL DETAIL -->
        @if(isset($jadwals))
        <div class="card">

            <div class="header-label">
                @if(isset($lansia))
                    Jadwal: {{ $lansia->nama_lansia }} ({{ $lansia->id_lansia }})
                @else
                    Jadwal Semua Lansia
                @endif
            </div>

            @if($jadwals->count())
            <table>
                <thead>
                    <tr>
                        @if(!isset($lansia)) <th>Nama</th> @endif
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Kegiatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwals as $j)
                    <tr>
                        @if(!isset($lansia))
                            <td>{{ $j->lansia->nama_lansia }}</td>
                        @endif
                        <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }}</td>
                        <td>{{ $j->waktu }}</td>
                        <td>{{ $j->aktivitas }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty">Belum ada jadwal</div>
            @endif

        </div>
        @endif

    </div>
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
