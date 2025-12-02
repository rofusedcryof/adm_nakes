@extends('pengasuh.layout')

@section('content')

<style>
    /* BACKGROUND FULL HIJAU */
    .bg-green {
        background:#1E7F77;
        width:100%;
        min-height:calc(100vh - 90px);
        padding:25px 0 80px 0;
        position:relative;
        display:flex;
        justify-content:center;
    }

    /* LOGO WATERMARK */
    .bg-green::before {
        content:"";
        position:absolute;
        top:55%;
        left:50%;
        transform:translate(-50%, -50%);
        width:300px;
        height:300px;
        background:url('/images/HEALTHSYNC.png') no-repeat center;
        background-size:260px;
        opacity:.22;
    }

    /* CONTAINER DALAM */
    .wrap {
        width:360px;
        max-width:100%;
        position:relative;
        z-index:10;
        padding:0 14px;
    }

    /* CARD */
    .card {
        background:white;
        padding:18px;
        border-radius:18px;
        box-shadow:0 4px 10px rgba(0,0,0,0.15);
        margin-bottom:22px;
    }

    .title {
        font-size:1rem;
        font-weight:700;
        color:#2A857D;
        margin-bottom:14px;
    }

    /* Tombol Hijau */
    .btn-main {
        background:#2A857D;
        color:white;
        padding:8px 14px;
        border-radius:12px;
        font-size:.85rem;
        display:inline-block;
        text-decoration:none;
        margin-bottom:14px;
    }

    /* Item Lansia */
    .lansia-item {
        background:#F8FAFC;
        border:1px solid #E5E7EB;
        border-radius:12px;
        padding:12px;
        margin-bottom:10px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        font-size:.9rem;
        font-weight:600;
    }

    .btn-lihat {
        background:#2A857D;
        color:white;
        padding:6px 12px;
        border-radius:10px;
        font-size:.8rem;
        text-decoration:none;
    }

    /* TABEL */
    table {
        width:100%;
        border-collapse:collapse;
        overflow:hidden;
        border-radius:12px;
    }

    table th {
        background:#E5E7EB;
        color:#2A857D;
        padding:10px;
        font-size:.85rem;
        text-align:left;
    }

    table td {
        background:white;
        padding:10px;
        border-bottom:1px solid #f1f1f1;
        font-size:.85rem;
    }

    .empty {
        text-align:center;
        padding:20px;
        color:#555;
        font-size:.9rem;
    }
    .riwayat-list {
        display:flex;
        flex-direction:column;
        gap:14px;
    }

    .riwayat-item {
        background:#F9FAFB;
        border-radius:14px;
        padding:14px 16px;
        border-left:5px solid #2A857D;
        box-shadow:0 3px 8px rgba(0,0,0,0.12);
    }

    .riwayat-date {
        font-size:.9rem;
        font-weight:700;
        color:#2A857D;
        margin-bottom:10px;
    }

    .riwayat-row {
        display:flex;
        justify-content:space-between;
        padding:6px 0;
        border-bottom:1px solid #e5e7eb;
    }

    .riwayat-row:last-child {
        border-bottom:none;
    }

    .r-label {
        font-size:.85rem;
        color:#555;
    }

    .r-value {
        font-size:.85rem;
        font-weight:700;
        color:#222;
    }


</style>

<div class="bg-green">
    <div class="wrap">

        {{-- CARD LIST LANSIA --}}
        <div class="card">
            <div class="title">Jadwal Kegiatan Lansia</div>

            <a href="{{ route('pengasuh.kegiatan-lansia.index') }}" class="btn-main">
                Semua Lansia
            </a>

            @foreach($allLansia as $l)
                <div class="lansia-item">
                    {{ $l->nama_lansia }} ({{ $l->id_lansia }})
                    <a class="btn-lihat" href="{{ route('pengasuh.kegiatan-lansia.show', $l->id_lansia) }}">
                        Lihat
                    </a>
                </div>
            @endforeach
        </div>

{{-- JADWAL SEMUA LANSIA --}}
<div class="card">

    @isset($lansia)
        <div class="title">
            Jadwal: {{ $lansia->nama_lansia }} ({{ $lansia->id_lansia }})
        </div>
    @else
        <div class="title">Jadwal Semua Lansia</div>
    @endisset


    @if($jadwals->isEmpty())
        <div class="empty">Belum ada jadwal tersedia.</div>
    @else

        <div class="riwayat-list">
            @foreach($jadwals as $j)
            <div class="riwayat-item">

                <div class="riwayat-date">
                    {{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}
                    {{ $j->waktu ? \Carbon\Carbon::parse($j->waktu)->format('H:i') : '' }}
                </div>

                <div class="riwayat-row">
                    <span class="r-label">Nama Lansia</span>
                    <span class="r-value">{{ $j->lansia->nama_lansia }}</span>
                </div>

                <div class="riwayat-row">
                    <span class="r-label">Tanggal</span>
                    <span class="r-value">
                        {{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }}
                    </span>
                </div>

                <div class="riwayat-row">
                    <span class="r-label">Waktu</span>
                    <span class="r-value">
                        {{ $j->waktu ? \Carbon\Carbon::parse($j->waktu)->format('H:i') : '-' }}
                    </span>
                </div>

                <div class="riwayat-row">
                    <span class="r-label">Kegiatan</span>
                    <span class="r-value">{{ $j->kegiatan }}</span>
                </div>

            </div>
            @endforeach
        </div>

    @endif

</div>


</div>

@endsection
