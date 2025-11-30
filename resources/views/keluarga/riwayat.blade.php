@extends('keluarga.layout')

@section('content')
    @php $count = $lansiaList->count(); @endphp
    @if($count > 1)
        <div class="section-title">PILIH LANSIA</div>
        <div class="card">
            <form method="GET" action="{{ route('keluarga.riwayat') }}">
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

    <div class="section-title">RIWAYAT KONDISI</div>
    <div class="card">
        @if($riwayat->isEmpty())
            <div>Tidak ada data untuk lansia ini.</div>
        @else
            <ul class="list">
                @foreach($riwayat as $r)
                    <li>
                        {{ $r->diukur_pada->format('d/m/Y H:i') }} — TD {{ $r->sistol }}/{{ $r->diastol }}, Nadi {{ $r->nadi }}, Suhu {{ $r->suhu }}, Gula {{ $r->gula_darah }}
                        @if($r->catatan)
                            <div>{{ $r->catatan }}</div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
