@extends('pengasuh.layout')

@section('content')

<style>
    .bg-green {
        background:#1E7F77;
        width:100%;
        min-height:calc(100vh - 90px);
        padding:25px 0 70px 0;
        position:relative;
        display:flex;
        justify-content:center;
    }

    .bg-green::before {
        content:"";
        position:absolute;
        top:52%;
        left:50%;
        transform:translate(-50%, -50%);
        width:300px;
        height:300px;
        background:url('/images/HEALTHSYNC.png') no-repeat center;
        background-size:260px;
        opacity:.22;
    }

    .wrap {
        width:360px;
        max-width:100%;
        position:relative;
        z-index:10;
        padding:0 14px;
    }

    .card {
        background:white;
        padding:18px;
        border-radius:16px;
        box-shadow:0 4px 12px rgba(0,0,0,0.15);
        margin-bottom:20px;
    }

    .label {
        font-weight:700;
        font-size:.9rem;
        color:#2A857D;
        margin-bottom:8px;
    }

    select {
        width:100%;
        padding:12px;
        border-radius:10px;
        border:1px solid #dcdcdc;
        font-size:.9rem;
    }

    table {
        width:100%;
        border-collapse:collapse;
        margin-top:10px;
    }

    th {
        padding:10px;
        background:#E5E7EB;
        color:#2A857D;
        font-size:.85rem;
        text-align:left;
    }

    td {
        padding:10px;
        background:#F9FAFB;
        font-size:.85rem;
        border-bottom:1px solid #e0e0e0;
    }

    .empty {
        padding:18px;
        text-align:center;
        color:#666;
    }

    .title-top {
        font-size:1rem;
        font-weight:700;
        color:white;
        margin-bottom:14px;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .back-btn {
        font-size:1.3rem;
        text-decoration:none;
        color:white;
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

       <div class="title-top">RIWAYAT KONDISI LANSIA</div>


        {{-- PILIH LANSIA --}}
        <div class="card">
            <div class="label">Nama Lansia</div>
            <form method="GET" action="{{ route('pengasuh.riwayat') }}">
                <select name="lansia_id" onchange="this.form.submit()">
                    @foreach($lansia as $l)
                        <option value="{{ $l->id }}"
                            {{ $selectedId == $l->id ? 'selected' : '' }}>
                            {{ $l->nama_lansia }} ({{ $l->id_lansia }})
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

{{-- DATA RIWAYAT --}}
<div class="card">

    @if($riwayat->isEmpty())
        <div class="empty">Tidak ada data riwayat.</div>
    @else

        <div class="riwayat-list">

            @foreach($riwayat as $r)
            <div class="riwayat-item">

                <div class="riwayat-date">
                    {{ $r->diukur_pada->format('d/m/Y H:i') }}
                </div>

                <div class="riwayat-row">
                    <span class="r-label">Tekanan</span>
                    <span class="r-value">
                        @if($r->sistol && $r->diastol)
                            {{ $r->sistol }}/{{ $r->diastol }} mmHg
                        @else
                            -
                        @endif
                    </span>
                </div>

                <div class="riwayat-row">
                    <span class="r-label">Nadi</span>
                    <span class="r-value">{{ $r->nadi ?? '-' }} bpm</span>
                </div>

                <div class="riwayat-row">
                    <span class="r-label">Suhu</span>
                    <span class="r-value">{{ $r->suhu ? $r->suhu . '°C' : '-' }}</span>
                </div>

                <div class="riwayat-row">
                    <span class="r-label">Gula Darah</span>
                    <span class="r-value">{{ $r->gula_darah ? $r->gula_darah . ' mg/dL' : '-' }}</span>
                </div>

            </div>
            @endforeach
        
        </div>

    @endif

</div>


    </div>
</div>

@endsection
