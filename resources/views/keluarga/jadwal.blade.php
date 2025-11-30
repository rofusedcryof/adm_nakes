@extends('keluarga.layout')

@section('content')
    @php $count = $lansiaList->count(); @endphp
    @if($count > 1)
        <div class="section-title">PILIH LANSIA</div>
        <div class="card">
            <form method="GET" action="{{ route('keluarga.jadwal') }}">
                <select name="lansia_id" onchange="this.form.submit()">
                    @foreach($lansiaList as $l)
                        <option value="{{ $l->id }}" {{ $selectedId == $l->id ? 'selected' : '' }}>
                            {{ $l->nama_lansia }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    @elseif($count === 1)
        <div class="section-title">LANSIA</div>
        <div class="card">{{ $lansiaList->first()->nama_lansia }}</div>
    @else
        <div class="card">Belum ada lansia terkait akun keluarga ini.</div>
    @endif

    <div class="section-title">JADWAL KEGIATAN</div>
    <div class="card">
        @if($jadwal->isEmpty())
            <div>Tidak ada jadwal untuk lansia ini.</div>
        @else
            <ul class="list">
                @foreach($jadwal as $j)
                    <li>
                        {{ optional($j->tanggal)->format('d/m/Y') }} {{ $j->waktu }} — {{ $j->aktivitas }} @if($j->lokasi) ({{ $j->lokasi }}) @endif
                        @if($j->catatan)
                            <div>{{ $j->catatan }}</div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
