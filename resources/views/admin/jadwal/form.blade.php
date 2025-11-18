@extends('layouts.app') 

@section('title', $mode==='create' ? 'Tambah Jadwal Kegiatan' : 'Edit Jadwal Kegiatan')

@section('content')

<style>
    /* HILANGKAN LOGO HEALTHSYNC DI BACKGROUND FORM */
    .logo-bg,
    .logo-wrapper,
    .logo-center,
    .healthsync-background,
    .healthsync-logo,
    .center-logo,
    .middle-logo,
    img[alt="HEALTHSYNC"],
    img[src*="healthsync"],
    img[src*="logo"] {
        display: none !important;
    }

    /* Hilangkan sidebar */
    .left-panel,
    .sidebar,
    .side-menu,
    .menu-wrapper,
    .nav-vertical,
    .panel-kiri {
        display: none !important;
    }

    /* Konten full width */
    .content-wrapper,
    .main-content,
    .container-main,
    .right-panel {
        width: 100% !important;
        margin-left: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* Hilangkan jarak besar bagian atas container */
    .content-wrapper,
    .main-content {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    /* Form dinaikkan ke atas & center */
    .content-card {
        background: #ffffff;
        width: 600px;
        margin: 40px auto 50px auto !important;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        position: relative;

    }

    @media(max-width: 768px){
        .content-card{
            width: 90%;
            top: -40px;
        }
    }
</style>

<div class="content-card">
    <h2 style="color:#2A857D;font-size:1.5rem;margin-bottom:1.5rem;">
        {{ $mode==='create' ? 'Tambah' : 'Edit' }} Jadwal Kegiatan
    </h2>

    @if($errors->any())
        <div class="alert-error" style="padding:10px;background:#fbebeb;color:#D32F2F;border-radius:5px;margin-bottom:15px;">
            <strong>*Terjadi Kesalahan!</strong>
            <ul style="margin:5px 0 0 20px;padding:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $mode==='create' ? route('admin.jadwal.store') : route('admin.jadwal.update', $item) }}">
        @csrf
        @if($mode==='edit') @method('PUT') @endif

        @if($mode==='edit' && isset($item->id_jadwal))
            <label for="id_jadwal">ID Jadwal</label>
            <input id="id_jadwal" type="text" value="{{ $item->id_jadwal }}" readonly style="background:#eee;"/>
        @endif

        <label for="lansia_id">Lansia</label>
        <select id="lansia_id" name="lansia_id" required>
            <option value="">-- Pilih Lansia --</option>
            @foreach($lansia as $l)
                <option value="{{ $l->id }}" @selected(old('lansia_id', $item->lansia_id ?? '') == $l->id)>
                    {{ $l->nama_lansia }} ({{ $l->id_lansia }})
                </option>
            @endforeach
        </select>

        <label for="tanggal">Tanggal</label>
        <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', $item->tanggal ?? '') }}" required />

        <label for="waktu">Waktu</label>
        <input id="waktu" type="time" name="waktu" value="{{ old('waktu', $item->waktu ?? '') }}" required />

        <label for="aktivitas">Aktivitas</label>
        <textarea id="aktivitas" name="aktivitas" rows="3" required placeholder="Contoh: Konsultasi kesehatan rutin, Senam pagi">{{ old('aktivitas', $item->aktivitas ?? '') }}</textarea>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Simpan</button>
            <a href="{{ route('admin.jadwal.home') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>

@endsection
