@extends('keluarga.layout')

@section('content')

<style>
    /* ==================== Dropdown ==================== */
    .select-box {
        width:100%;
        padding:12px 16px;
        border-radius:14px;
        border:1px solid #d1d5db;
        font-size:0.95rem;
        background:white;
        appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg fill='none' stroke='%232A857D' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat:no-repeat;
        background-position:right 14px center;
        background-size:18px;
        box-shadow:0 2px 6px rgba(0,0,0,0.07);
    }

    /* ==================== Section title ==================== */
    .section-head {
        font-weight:700;
        font-size:0.95rem;
        color:white;
        margin-top:14px;
        margin-bottom:6px;
        display:flex;
        align-items:center;
        gap:6px;
    }

    /* ==================== Card item ==================== */
    .riwayat-item {
        padding:12px 2px;
        border-bottom:1px solid #edf2f7;
        font-size:0.9rem;
    }
    .riwayat-item:last-child { border-bottom:none; }

    .nama-lansia {
        font-weight:700;
        font-size:0.95rem;
        margin-bottom:3px;
        color:#111827;
    }

    .detail-kondisi {
        font-size:0.86rem;
        color:#374151;
        line-height:1.35rem;
    }

    .catatan-area {
        margin-top:6px;
        padding-left:8px;
        border-left:3px solid #2A857D;
        font-size:0.82rem;
        color:#4b5563;
        line-height:1.3rem;
    }

    .timestamp {
        float:right;
        font-size:0.72rem;
        color:#6b7280;
    }
</style>


<!-- ==================== PILIH LANSIA ==================== -->
<div class="section-head">📌 PILIH LANSIA</div>

<div class="card">
    <form method="GET" action="{{ route('keluarga.riwayat') }}">
        <select class="select-box" name="lansia_id" onchange="this.form.submit()">
            <option value="all" {{ $selectedId=='all' ? 'selected' : '' }}>
                ➤ Tampilkan Semua Lansia
            </option>

            @foreach($lansiaList as $l)
                <option value="{{ $l->id }}" {{ $selectedId==$l->id ? 'selected' : '' }}>
                    {{ $l->nama_lansia }}
                </option>
            @endforeach
        </select>
    </form>
</div>


<!-- ==================== RIWAYAT ==================== -->
<div class="section-head" style="margin-top:20px;">📊 RIWAYAT KONDISI</div>

<div class="card">

    @if($riwayat->isEmpty())

        <div style="padding:6px 0;">Tidak ada riwayat kondisi.</div>

    @else
        <ul class="list">
            @foreach($riwayat as $r)
                <li class="riwayat-item">

                    @if($selectedId=='all')
                        <div class="nama-lansia">{{ $r->lansia->nama_lansia }}</div>
                    @endif

                    <div class="detail-kondisi">
                        <span class="timestamp">{{ $r->diukur_pada->format('d/m/Y H:i') }}</span>

                        TD {{ $r->sistol }}/{{ $r->diastol }},
                        Nadi {{ $r->nadi }},
                        Suhu {{ $r->suhu }}°C,
                        Gula {{ $r->gula_darah }}
                    </div>

                    @if($r->catatan)
                        <div class="catatan-area">
                            📝 {{ $r->catatan }}
                        </div>
                    @endif

                </li>
            @endforeach
        </ul>
    @endif
</div>

@endsection
