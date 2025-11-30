<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH SYNC - Riwayat Kondisi Lansia</title>

<style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:Arial, sans-serif; }

    body {
        background:#E5E5E5;
        padding-bottom:90px;
    }

    /* HEADER */
    .header {
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

    /* BACKGROUND HIJAU + LOGO */
    .bg-green {
        background:#1E7F77;
        width:100%;
        padding-top:35px;
        padding-bottom:60px;
        min-height:calc(100vh - 130px);
        position:relative;
        background-image:url('/images/HEALTHSYNC.png');
        background-repeat:no-repeat;
        background-position:center 250px;
        background-size:240px;
        opacity:0.97;
    }

    .bg-green::before {
        content:"";
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-image:url('/images/HEALTHSYNC.png');
        background-size:260px;
        background-repeat:no-repeat;
        background-position:center 120px;
        opacity:0.14;
        filter:blur(2px);
        z-index:0;
    }

    .container {
        width:360px;
        max-width:calc(100% - 20px);
        margin:auto;
        position:relative;
        z-index:5;
    }

    /* BOX PUTIH BESAR */
    .content-box {
        background:white;
        border-radius:16px;
        padding:18px;
        box-shadow:0 4px 10px rgba(0,0,0,0.2);
        margin-top:10px;
    }

    label {
        font-weight:700;
        color:#444;
        font-size:0.9rem;
    }

    select {
        width:100%;
        padding:12px;
        border-radius:12px;
        border:1px solid #DDD;
        margin-top:8px;
        font-size:1rem;
    }

    /* RIWAYAT ITEM */
    .riwayat-item {
        background:white;
        border-radius:16px;
        padding:16px;
        margin-top:18px;
        box-shadow:0 4px 10px rgba(0,0,0,0.15);
    }

    .riwayat-date {
        font-weight:bold;
        color:#2A857D;
        margin-bottom:12px;
        padding-bottom:6px;
        border-bottom:1px solid #DDD;
    }

    .riwayat-body {
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:10px;
    }

    .riwayat-item-label {
        color:#6B6B6B;
        font-size:0.85rem;
    }

    .riwayat-item-value {
        font-weight:bold;
        color:#2A857D;
        margin-top:2px;
    }

    .empty-state {
        text-align:center;
        padding:20px 0;
        color:#888;
    }

    /* ⭐ NAVBAR DASHBOARD ASLI */
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

    .nav-item.active {
        color:#2A857D;
        font-weight:bold;
    }

    .nav-icon {
        width:22px;
        height:22px;
        margin-bottom:2px;
        background-size:contain;
        background-repeat:no-repeat;
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

<div class="header">
    <button class="back-btn" onclick="window.location.href='{{ route('pengasuh.dashboard') }}'">←</button>
    RIWAYAT KONDISI LANSIA
</div>

<div class="bg-green">
    <div class="container">

        <div class="content-box">

            <label>Nama Lansia</label>
            <form method="GET" action="{{ route('pengasuh.riwayat') }}">
                <select name="lansia_id" onchange="this.form.submit()">
                    <option value="">-- Pilih Lansia --</option>
                    @foreach($lansia as $l)
                        <option value="{{ $l->id }}" {{ $selectedId == $l->id ? 'selected' : '' }}>
                            {{ $l->nama_lansia }} ({{ $l->id_lansia }})
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- RIWAYAT LIST -->
            @if($riwayat->count() > 0)
                @foreach($riwayat as $r)
                    <div class="riwayat-item">
                        <div class="riwayat-date">{{ $r->diukur_pada->format('d/m/Y H:i') }}</div>

                        <div class="riwayat-body">
                            @if($r->sistol && $r->diastol)
                                <div>
                                    <div class="riwayat-item-label">Tekanan Darah</div>
                                    <div class="riwayat-item-value">{{ $r->sistol }}/{{ $r->diastol }} mmHg</div>
                                </div>
                            @endif

                            @if($r->nadi)
                                <div>
                                    <div class="riwayat-item-label">Nadi</div>
                                    <div class="riwayat-item-value">{{ $r->nadi }} bpm</div>
                                </div>
                            @endif

                            @if($r->suhu)
                                <div>
                                    <div class="riwayat-item-label">Suhu</div>
                                    <div class="riwayat-item-value">{{ $r->suhu }}°C</div>
                                </div>
                            @endif

                            @if($r->gula_darah)
                                <div>
                                    <div class="riwayat-item-label">Gula Darah</div>
                                    <div class="riwayat-item-value">{{ $r->gula_darah }} mg/dL</div>
                                </div>
                            @endif
                        </div>

                        @if($r->catatan)
                            <div style="border-top:1px solid #DDD; margin-top:10px; padding-top:8px;">
                                <div class="riwayat-item-label">Catatan</div>
                                <div style="color:#2A857D;">{{ $r->catatan }}</div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="riwayat-item">
                    <div class="empty-state">Tidak ada data riwayat.</div>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- NAVIGATION BAR -->
<div class="bottom-nav">
    <div class="nav-inner">

        <!-- HOME -->
        <a href="{{ route('pengasuh.dashboard') }}" class="nav-item active">
            <span class="nav-icon icon-home"></span><br>Home
        </a>

        <!-- NOTIFIKASI -->
        <a href="#" class="nav-item">
            <span class="nav-icon icon-bell"></span><br>Notifikasi
        </a>

        <!-- PROFILE -->
        <a href="#" class="nav-item">
            <span class="nav-icon icon-user"></span><br>Profile
        </a>

    </div>
</div>

</body>
</html>
