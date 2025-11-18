@extends('layouts.app')

@section('title', $mode==='create' ? 'Tambah Instruksi Obat' : 'Edit Instruksi Obat')

@section('content')

<style>
    /* HILANGKAN LOGO HEALTHSYNC DI BACKGROUND */
    .logo-placeholder {
        display: none !important;
    }

    /* HILANGKAN SELURUH SIDEBAR */
    .sidebar,
    #sidebar,
    .side-menu,
    .side-btn,
    .left-panel,
    .nav-vertical {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
    }

    /* Hilangkan ruang bekas sidebar */
    .wrap {
        display: block !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    /* Hilangkan NOTIFIKASI di mana pun */
    a[href*="notif"],
    a[href*="notifikasi"] {
        display: none !important;
    }

    /* FORM AREA */
    .content {
        width: 100% !important;
        background: #2A857D !important;
        padding: 2rem 0 !important;
        border-radius: 0 !important;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        overflow: visible !important;
        position: relative;
    }

    .content-card {
        background: #ffffff;
        width: 600px;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-top: 40px;
    }

    @media(max-width: 768px) {
        .content-card {
            width: 90%;
        }
    }

    label {
        display: block;
        font-weight: 700;
        margin-top: 1rem;
    }

    input, select, textarea {
        width: 100%;
        padding: .7rem;
        border-radius: 8px;
        border: 2px solid #d1d5db;
        font-size: 1rem;
    }

    .row {
        display: flex;
        gap: 1rem;
    }

    .row > div {
        flex: 1;
    }

</style>

<div class="content-card">

    <h2 style="color:#2A857D;font-size:1.5rem;margin-bottom:1.5rem;text-align:center;">
        {{ $mode==='create' ? 'Tambah Instruksi Obat' : 'Edit Instruksi Obat' }}
    </h2>

    @if ($errors->any())
        <div class="alert-error" style="padding:10px;background:#fbebeb;color:#D32F2F;border-radius:5px;margin-bottom:15px;">
            <strong>*Terjadi Kesalahan!</strong>
            <ul style="margin:5px 0 0 20px;padding:0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST"
          action="{{ $mode === 'create'
                    ? route('medis.instruksi.store')
                    : route('medis.instruksi.update', $item->id ?? $item) }}">

        @csrf
        @if ($mode === 'edit') @method('PUT') @endif


        <label>Lansia <span style="color:#dc2626">*</span></label>
        <select name="lansia_id" required>
            <option value="">-- Pilih Lansia --</option>
            @foreach ($lansia as $l)
                <option value="{{ $l->id }}" @selected(old('lansia_id', $item->lansia_id ?? null) == $l->id)>
                    {{ $l->nama_lansia }} ({{ $l->id_lansia }})
                </option>
            @endforeach
        </select>


        <label>Nama Obat <span style="color:#dc2626">*</span></label>
        <input type="text" name="nama_obat"
               value="{{ old('nama_obat', $item->nama_obat ?? '') }}"
               placeholder="Contoh: Paracetamol"
               required>


        <div class="row">
            <div>
                <label>Dosis</label>
                <input type="text"
                       name="dosis"
                       placeholder="Contoh: 5mg"
                       value="{{ old('dosis', $item->dosis ?? '') }}">
            </div>

            <div>
                <label>Frekuensi</label>
                <input type="text"
                       name="frekuensi"
                       placeholder="Contoh: 1x sehari"
                       value="{{ old('frekuensi', $item->frekuensi ?? '') }}">
            </div>
        </div>


        <div class="row">
            <div>
                <label>Mulai Pada</label>
                <input type="date"
                       name="mulai_pada"
                       value="{{ old('mulai_pada', optional($item->mulai_pada)->format('Y-m-d')) }}">
            </div>

            <div>
                <label>Selesai Pada</label>
                <input type="date"
                       name="selesai_pada"
                       value="{{ old('selesai_pada', optional($item->selesai_pada)->format('Y-m-d')) }}">
            </div>
        </div>


        <label>Status</label>
        <select name="status">
            @foreach (['aktif','selesai','ditunda'] as $s)
                <option value="{{ $s }}"
                        @selected(old('status', $item->status ?? 'aktif') == $s)>
                    {{ ucfirst($s) }}
                </option>
            @endforeach
        </select>


        <label>Catatan</label>
        <textarea name="catatan" rows="4">{{ old('catatan', $item->catatan ?? '') }}</textarea>


        <div style="display:flex; gap:10px; margin-top:1.5rem;">
            <button type="submit"
                    style="background:#2A857D;color:white;padding:10px 18px;border:none;border-radius:6px;cursor:pointer;">
                Simpan
            </button>

            <a href="{{ route('medis.instruksi.index') }}"
               style="background:#6c757d;color:white;padding:10px 18px;border-radius:6px;text-decoration:none;">
                Batal
            </a>
        </div>

    </form>

</div>

@endsection
