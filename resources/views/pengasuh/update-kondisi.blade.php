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
        top:55%;
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
        padding:20px;
        border-radius:16px;
        box-shadow:0 4px 12px rgba(0,0,0,0.15);
        margin-bottom:20px;
    }

    .label {
        font-weight:700;
        font-size:.88rem;
        margin-bottom:6px;
        color:#2A857D;
    }

    .input-field,
    select {
        width:100%;
        padding:10px;
        border-radius:10px;
        border:1px solid #dcdcdc;
        font-size:.9rem;
        margin-bottom:14px;
    }

    .row-2 {
        display:flex;
        gap:10px;
    }

    .row-2 .input-field {
        flex:1;
    }

    textarea {
        width:100%;
        padding:10px;
        border-radius:10px;
        border:1px solid #dcdcdc;
        min-height:80px;
        font-size:.9rem;
    }

    .btn-primary {
        width:100%;
        padding:12px;
        background:#2A857D;
        color:white;
        font-weight:bold;
        border:none;
        border-radius:10px;
        margin-top:6px;
        margin-bottom:10px;
    }

    .btn-danger {
        width:100%;
        padding:12px;
        background:#d9534f;
        color:white;
        font-weight:bold;
        border:none;
        border-radius:10px;
    }

    .title-page {
        color:white;
        font-size:1rem;
        font-weight:700;
        text-align:center;
        margin-bottom:16px;
    }
</style>


<div class="bg-green">
    <div class="wrap">

        <div class="title-page">INPUT KONDISI LANSIA</div>

        <div class="card">

            @if(session('success'))
                <div style="background:#D1FAE5; padding:10px; border-radius:10px; color:#065F46; margin-bottom:15px;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('pengasuh.update-kondisi.store') }}">
                @csrf

                {{-- PILIH LANSIA --}}
                <label class="label">Lansia *</label>
                <select name="lansia_id" required>
                    <option value="">-- Pilih Lansia --</option>
                    @foreach($lansia as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_lansia }} ({{ $l->id_lansia }})</option>
                    @endforeach
                </select>

                {{-- TANGGAL & WAKTU --}}
                <div class="row-2">
                    <div style="flex:1;">
                        <label class="label">Tanggal *</label>
                        <input type="date" name="tanggal" class="input-field" required>
                    </div>

                    <div style="flex:1;">
                        <label class="label">Waktu *</label>
                        <input type="time" name="waktu" class="input-field" required>
                    </div>
                </div>

                {{-- TEKANAN DARAH --}}
                <div class="row-2">
                    <div>
                        <label class="label">Sistol (mmHg)</label>
                        <input type="number" name="sistol" class="input-field" placeholder="120">
                    </div>

                    <div>
                        <label class="label">Diastol (mmHg)</label>
                        <input type="number" name="diastol" class="input-field" placeholder="80">
                    </div>
                </div>

                {{-- NADI & SUHU --}}
                <div class="row-2">
                    <div>
                        <label class="label">Nadi (bpm)</label>
                        <input type="number" name="nadi" class="input-field" placeholder="72">
                    </div>

                    <div>
                        <label class="label">Suhu (°C)</label>
                        <input type="number" step="0.1" name="suhu" class="input-field" placeholder="36.5">
                    </div>
                </div>

                {{-- GULA DARAH --}}
                <label class="label">Gula Darah (mg/dL)</label>
                <input type="number" name="gula_darah" class="input-field" placeholder="100">

                {{-- CATATAN --}}
                <label class="label">Catatan</label>
                <textarea name="catatan" placeholder="Catatan tambahan..."></textarea>

                {{-- BUTTON --}}
                <button class="btn-primary">Simpan</button>

                <a href="{{ route('pengasuh.dashboard') }}">
                    <button type="button" class="btn-danger">Batal</button>
                </a>

            </form>
        </div>

    </div>
</div>

@endsection
