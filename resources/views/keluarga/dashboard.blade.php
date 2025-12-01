@extends('keluarga.layout')

@section('content')

<style>
    /* Animasi lembut saat muncul */
    .card-dashboard {
        animation: fadeUp .35s ease;
    }
    @keyframes fadeUp {
        from { transform: translateY(10px); opacity:0; }
        to   { transform: translateY(0); opacity:1; }
    }

    /* Struktur judul dalam card */
    .card-section-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:6px;
    }
    .card-section-title {
        font-weight:700;
        font-size:0.95rem;
        color:#1f2937;
    }
    .section-sub {
        font-size:0.8rem;
        color:#6b7280;
        margin-bottom:6px;
    }

    /* Tombol lihat semua */
    .see-all-btn {
        font-size:0.75rem;
        padding:4px 8px;
        background:#f5f8fa;
        border:1px solid #d1d5db;
        border-radius:999px;
        color:#2A857D;
        text-decoration:none;
    }

    /* List item */
    .clean-list { list-style:none; padding:0; margin:0; }
    .clean-list li {
        padding:10px 0;
        border-bottom:1px solid #eef2f7;
    }
    .clean-list li:last-child { border-bottom:none; }

    /* Header dalam item */
    .item-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:4px;
    }
    .item-name {
        font-weight:700;
        color:#1f2937;
        font-size:0.92rem;
    }
    .item-date {
        font-size:0.75rem;
        color:#6b7280;
        white-space:nowrap;
    }

    /* Informasi utama */
    .item-info {
        color:#374151;
        font-size:0.85rem;
        margin-bottom:3px;
    }

    /* Catatan */
    .item-note {
        margin-top:4px;
        font-size:0.82rem;
        color:#6b7280;
    }
</style>


{{-- ================= FLASH SUCCESS ================ --}}
@if(session('success'))
    <div class="card card-dashboard" style="background:#e8fff0; color:#0f5132;">
        {{ session('success') }}
    </div>
@endif


{{-- ================== RIWAYAT KONDISI ================== --}}
<div class="section-title">
    📊 RIWAYAT KONDISI LANSIA
</div>

<div class="card card-dashboard">

    <div class="card-section-header">
        <div class="card-section-title">Terbaru</div>
        <a href="{{ route('keluarga.riwayat') }}" class="see-all-btn">Lihat semua</a>
    </div>

    <div class="section-sub">Ringkasan 3 pengukuran terakhir</div>

    <ul class="clean-list">
        @foreach($riwayatTerbaru->take(3) as $r)
        <li>
            <div class="item-header">
                <span class="item-name">{{ $r->lansia->nama_lansia }}</span>
                <span class="item-date">{{ $r->diukur_pada->format('d/m/Y H:i') }}</span>
            </div>

            <div class="item-info">
                TD {{ $r->sistol }}/{{ $r->diastol }},
                Nadi {{ $r->nadi }},
                Suhu {{ $r->suhu }}°C,
                Gula {{ $r->gula_darah }}
            </div>

            @if($r->catatan)
                <div class="item-note">📝 {{ $r->catatan }}</div>
            @endif
        </li>
        @endforeach
    </ul>

</div>



{{-- ================== JADWAL KEGIATAN ================== --}}
<div class="section-title" style="margin-top:18px;">
    📅 JADWAL KEGIATAN LANSIA
</div>

<div class="card card-dashboard">

    <div class="card-section-header">
        <div class="card-section-title">Mendatang</div>
        <a href="{{ route('keluarga.jadwal') }}" class="see-all-btn">Lihat semua</a>
    </div>

    <div class="section-sub">3 jadwal terdekat dari semua lansia</div>

    <ul class="clean-list">
        @foreach($jadwalMendatang->take(3) as $j)
        <li>
            <div class="item-header">
                <span class="item-name">{{ $j->lansia->nama_lansia }}</span>
                <span class="item-date">
                    {{ optional($j->tanggal)->format('d/m/Y') }} {{ $j->waktu }}
                </span>
            </div>

            <div class="item-info">
                {{ $j->aktivitas }}
                @if($j->lokasi)
                    <span style="color:#6b7280;">({{ $j->lokasi }})</span>
                @endif
            </div>

            @if($j->catatan)
                <div class="item-note">📝 {{ $j->catatan }}</div>
            @endif
        </li>
        @endforeach
    </ul>

</div>

@endsection
