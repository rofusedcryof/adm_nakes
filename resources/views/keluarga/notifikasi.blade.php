@extends('keluarga.layout')

@section('content')

<style>
    .notif-card {
        background:white;
        border-radius:16px;
        padding:18px;
        box-shadow:0 4px 12px rgba(0,0,0,0.15);
    }

    .notif-list {
        list-style:none;
        padding:0;
        margin:0;
    }

    .notif-item {
        padding:12px 0;
        border-bottom:1px solid #eee;
    }
    .notif-item:last-child { border-bottom:none; }

    /* Badge Emergency */
    .notif-type-emergency {
        color:#b91c1c;
        font-size:0.85rem;
        font-weight:700;
        display:flex;
        align-items:center;
        gap:4px;
    }

    /* Badge Info */
    .notif-type-info {
        color:#1d4ed8;
        font-size:0.85rem;
        font-weight:700;
        display:flex;
        align-items:center;
        gap:4px;
    }

    .notif-date {
        font-size:0.75rem;
        color:#666;
    }

    .notif-message {
        margin-top:4px;
        font-size:0.9rem;
        line-height:1.35rem;
        color:#333;
    }
</style>


<div class="notif-card">

    <h3 style="margin-bottom:12px; color:#2A857D; font-size:1.1rem;">Notifikasi</h3>

    @if($notifikasi->isEmpty())
        <div style="text-align:center; padding:20px 0; color:#666;">
            Belum ada notifikasi.
        </div>
    @else
        <ul class="notif-list">

            @foreach($notifikasi as $n)
                <li class="notif-item">

                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        @if($n->tipe === 'emergency')
                            <span class="notif-type-emergency">🚨 EMERGENCY</span>
                        @else
                            <span class="notif-type-info">ℹ️ INFO</span>
                        @endif

                        <span class="notif-date">{{ $n->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="notif-message">
                        {{ $n->pesan }}
                    </div>

                </li>
            @endforeach

        </ul>
    @endif

</div>

@endsection
