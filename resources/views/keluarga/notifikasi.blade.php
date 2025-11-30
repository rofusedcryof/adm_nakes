@extends('keluarga.layout')

@section('content')
    <div class="card">
        <h3>Notifikasi</h3>
        @if($notifikasi->isEmpty())
            <div>Belum ada notifikasi.</div>
        @else
            <ul class="list">
                @foreach($notifikasi as $n)
                    <li>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <strong>{{ strtoupper($n->tipe) }}</strong>
                            <span style="color:#666; font-size:12px;">{{ $n->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>{{ $n->pesan }}</div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection

