@extends('pengasuh.layout')

@section('content')

<style>
    .bg-green {
        background:#1E7F77;
        width:100%;
        min-height:calc(100vh - 120px); /* penuh */
        padding-top:35px;
        padding-bottom:60px;
        position:relative;
        display:flex;
        justify-content:center;
    }

    .bg-green::before {
        content:"";
        position:absolute;
        top:50%;
        left:50%;
        width:300px;
        height:300px;
        transform:translate(-50%, -50%);
        background:url('/images/HEALTHSYNC.png') no-repeat center;
        background-size:260px;       
        opacity:0.5;                
        filter:blur(1px);            
        z-index:0;
    }

    .dashboard-container {
        width:360px;
        max-width:100%;
        position:relative;
        z-index:10;
        padding:0 12px;
    }

    /* KONDISI DARURAT – SAMA PERSIS */
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
        margin-bottom:40px;
        font-size:1rem;
    }

    /* SECTION TITLE – SAMA PERSIS */
    .section-title {
        color:white;
        font-weight:700;
        font-size:1rem;
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-top:35px;
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

    /* BOX UTAMA – SAMA PERSIS */
    .box {
        background:white;
        padding:16px;
        border-radius:16px;
        margin-bottom:32px;
        box-shadow:0 4px 8px rgba(0,0,0,0.22);
        font-size:0.95rem;
        display:block;
        text-decoration:none;
        color:black;
    }

    .lansia-item {
        background:#F9FAFB;
        padding:12px;
        border-radius:10px;
        margin-bottom:10px;
    }

    .box-soft {
        background:#F3F4F6;
        padding:16px;
        border-radius:16px;
        font-size:0.95rem;
        margin-bottom:32px;
        color:#6b6b6b;
        opacity:0.85;
        text-decoration:none;
        display:block;
    }
</style>


<div class="bg-green">
    <div class="dashboard-container">

        <!-- KONDISI DARURAT -->
        <form action="{{ route('pengasuh.kirim-notifikasi-darurat-langsung') }}" method="POST">
            @csrf
            <button type="submit" class="btn-danger">🚨 KONDISI DARURAT</button>
        </form>

        <!-- RIWAYAT -->
        <div class="section-title">
            <span>RIWAYAT KONDISI LANSIA</span>
            <a href="{{ route('pengasuh.riwayat') }}"><span class="icon icon-check"></span></a>
        </div>

        <a class="box" href="{{ route('pengasuh.riwayat') }}">
            @foreach($lansia as $l)
                <div class="lansia-item"><strong>{{ $l->nama_lansia }}</strong> ({{ $l->id_lansia }})</div>
            @endforeach
        </a>

        <!-- JADWAL -->
        <div class="section-title">
            <span>LIHAT KEGIATAN LANSIA</span>
            <a href="{{ route('pengasuh.kegiatan-lansia.index') }}"><span class="icon icon-check"></span></a>
        </div>

        <a class="box-soft" href="{{ route('pengasuh.kegiatan-lansia.index') }}">
            Klik icon ini untuk melihat jadwal kegiatan lansia
        </a>

        <!-- TAMBAH KONDISI -->
        <div class="section-title">
            <span>TAMBAH KONDISI LANSIA</span>
            <a href="{{ route('pengasuh.update-kondisi') }}"><span class="icon icon-plus"></span></a>
        </div>

        <a class="box-soft" href="{{ route('pengasuh.update-kondisi') }}">
            Klik icon ini untuk menambah kondisi lansia
        </a>

    </div>
</div>

@endsection
