@extends('keluarga.layout')

@section('content')

<style>
    .select-box {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        border: 1px solid #d6d6d6;
        font-size: 0.95rem;
        background: white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .filter-label {
        font-size: 0.8rem;
        color: #2A857D;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
        margin-bottom: 6px;
    }

    .filter-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-input {
        flex: 1;
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid #d6d6d6;
        font-size: 0.9rem;
        background: white;
    }

    .reset-btn {
        background: #e84b4b;
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: bold;
        cursor: pointer;
        white-space: nowrap;
    }

    .jadwal-item {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        font-size: 0.9rem;
    }
    .jadwal-item:last-child {
        border-bottom: none;
    }

    .lansia-label {
        font-weight: bold;
        color: #2A857D;
        margin-bottom: 4px;
        display: block;
    }
</style>


<!-- ==================== PILIH LANSIA ==================== -->
<div class="section-title">🔎 PILIH LANSIA</div>

<div class="card">
    <form method="GET" action="{{ route('keluarga.jadwal') }}">

        {{-- DROPDOWN LANSIA --}}
        <select class="select-box" name="lansia_id" onchange="this.form.submit()">
            <option value="all" {{ $selectedId=='all' ? 'selected' : '' }}>
                ➤ Tampilkan Semua Lansia
            </option>

            @foreach($lansiaList as $l)
                <option value="{{ $l->id }}" {{ $selectedId == $l->id ? 'selected' : '' }}>
                    {{ $l->nama_lansia }}
                </option>
            @endforeach
        </select>

        {{-- LABEL JIKA FILTER TANGGAL AKTIF --}}
        @if($selectedDate)
            <div class="filter-label">
                📅 Filter tanggal: {{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}
            </div>
        @else
            <div class="filter-label">
                📅 Filter berdasarkan tanggal (opsional)
            </div>
        @endif

        {{-- INPUT TANGGAL + RESET --}}
        <div class="filter-row">

            <input
                type="date"
                name="tanggal"
                class="filter-input"
                value="{{ $selectedDate }}"
                onchange="this.form.submit()"
            >

            @if($selectedDate)
                <button type="submit" name="reset" value="1" class="reset-btn">
                    Reset
                </button>
            @endif

        </div>

    </form>
</div>


<!-- ==================== JADWAL KEGIATAN ==================== -->
<div class="section-title">📅 JADWAL KEGIATAN</div>

<div class="card">
    @if($emptyMessage)
        <div style="text-align:center; padding:10px; color:#666;">
            {{ $emptyMessage }}
        </div>
    @elseif($jadwal->isEmpty())
        <div style="text-align:center; padding:10px; color:#666;">
            Tidak ada kegiatan.
        </div>
    @else
        <ul class="list">
            @foreach($jadwal as $j)
                <li class="jadwal-item">

                    @if($selectedId == 'all')
                        <span class="lansia-label">{{ $j->lansia->nama_lansia }}</span>
                    @endif

                    {{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}
                    {{ $j->waktu }} —
                    {{ $j->aktivitas }}

                    @if($j->lokasi)
                        ({{ $j->lokasi }})
                    @endif

                    @if($j->catatan)
                        <div style="margin-top:4px; font-size:0.85rem;">
                            📝 {{ $j->catatan }}
                        </div>
                    @endif

                </li>
            @endforeach
        </ul>
    @endif
</div>

@endsection
