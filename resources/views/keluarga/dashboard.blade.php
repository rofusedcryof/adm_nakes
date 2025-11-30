@extends('keluarga.layout')

@section('content')
    @if(session('success'))
        <div class="card" style="background:#e9fff1; color:#0f5132;">{{ session('success') }}</div>
    @endif

    <div class="section-title">RIWAYAT KONDISI LANSIA</div>
    <div class="card">
        <a class="add-btn" href="{{ route('keluarga.riwayat') }}">＋</a>
        @if($riwayatTerbaru->isEmpty())
            <div>Tidak ada data.</div>
        @else
            <ul class="list">
                @foreach($riwayatTerbaru as $r)
                    <li>
                        <strong>{{ $r->lansia->nama_lansia }}</strong> — {{ $r->diukur_pada->format('d/m/Y H:i') }}<br>
                        TD: {{ $r->sistol }}/{{ $r->diastol }} | Nadi: {{ $r->nadi }} | Suhu: {{ $r->suhu }} | Gula: {{ $r->gula_darah }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="section-title" style="margin-top:8px;">JADWAL KEGIATAN LANSIA</div>
    <div class="card">
        <a class="add-btn" href="{{ route('keluarga.jadwal') }}">＋</a>
        @if($jadwalMendatang->isEmpty())
            <div>Belum ada jadwal.</div>
        @else
            <ul class="list">
                @foreach($jadwalMendatang as $j)
                    <li>
                        <strong>{{ $j->lansia->nama_lansia }}</strong> — {{ optional($j->tanggal)->format('d/m/Y') }} {{ $j->waktu }}
                        <div>{{ $j->aktivitas }} @if($j->lokasi) ({{ $j->lokasi }}) @endif</div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
