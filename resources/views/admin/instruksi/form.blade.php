@extends('layouts.app') 

@section('title', $mode==='create' ? 'Tambah Instruksi Obat' : 'Edit Instruksi Obat')

@section('content')
<div class="content-card">
    <h2 style="color:#2A857D;font-size:1.5rem;margin-bottom:1.5rem;">{{ $mode==='create' ? 'Tambah' : 'Edit' }} Instruksi Obat</h2>

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

    <form method="POST" action="{{ $mode==='create' ? route('admin.instruksi.store') : route('admin.instruksi.update', $item) }}">
        @csrf
        @if($mode==='edit') @method('PUT') @endif

        <label for="lansia_id">Lansia <span style="color:#dc2626;">*</span></label>
        <select id="lansia_id" name="lansia_id" required>
            <option value="">-- Pilih Lansia --</option>
            @foreach($lansia as $l)
                <option value="{{ $l->id }}" @selected(old('lansia_id', $item->lansia_id ?? '') == $l->id)>
                    {{ $l->nama_lansia }} ({{ $l->id_lansia }})
                </option>
            @endforeach
        </select>

        <label for="nama_obat">Nama Obat <span style="color:#dc2626;">*</span></label>
        <input id="nama_obat" type="text" name="nama_obat" value="{{ old('nama_obat', $item->nama_obat ?? '') }}" required placeholder="Contoh: Paracetamol, Amlodipine, dll" />

        <div class="row">
            <div>
                <label for="dosis">Dosis</label>
                <input id="dosis" type="text" name="dosis" value="{{ old('dosis', $item->dosis ?? '') }}" placeholder="Contoh: 500mg, 5mg" />
            </div>
            <div>
                <label for="frekuensi">Frekuensi</label>
                <input id="frekuensi" type="text" name="frekuensi" value="{{ old('frekuensi', $item->frekuensi ?? '') }}" placeholder="Contoh: 3x sehari" />
            </div>
        </div>

        <div class="row">
            <div>
                <label for="mulai_pada">Mulai Pada</label>
                <input id="mulai_pada" type="date" name="mulai_pada" value="{{ old('mulai_pada', $item->mulai_pada?->format('Y-m-d')) }}" />
            </div>
            <div>
                <label for="selesai_pada">Selesai Pada</label>
                <input id="selesai_pada" type="date" name="selesai_pada" value="{{ old('selesai_pada', $item->selesai_pada?->format('Y-m-d')) }}" />
            </div>
        </div>

        <label for="status">Status</label>
        <select id="status" name="status">
            @foreach (['aktif','selesai','ditunda'] as $s)
                <option value="{{ $s }}" @selected(old('status', $item->status ?? 'aktif') == $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>

        <label for="medis_user_id">Tenaga Medis (Opsional)</label>
        <select id="medis_user_id" name="medis_user_id">
            <option value="">-- Pilih Tenaga Medis --</option>
            @foreach ($medis as $m)
                <option value="{{ $m->id }}" @selected(old('medis_user_id', $item->medis_user_id ?? '') == $m->id)>{{ $m->name }}</option>
            @endforeach
        </select>

        <label for="catatan">Catatan</label>
        <textarea id="catatan" name="catatan" rows="4" placeholder="Catatan tambahan tentang instruksi obat...">{{ old('catatan', $item->catatan ?? '') }}</textarea>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Simpan</button>
            <a href="{{ route('admin.instruksi.index') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>
@endsection
