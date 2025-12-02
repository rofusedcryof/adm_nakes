@extends('pengasuh.layout')

@section('content')

<style>
    /* BACKGROUND HIJAU FULL */
    .bg-green {
        background:#1E7F77;
        width:100%;
        min-height:calc(100vh - 90px);
        padding:25px 0 80px 0;
        position:relative;
        display:flex;
        justify-content:center;
        align-items:flex-start;
    }

    /* LOGO WATERMARK */
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

    /* WRAPPER DALAM */
    .wrap {
        width:360px;
        max-width:100%;
        position:relative;
        z-index:5;
        padding:0 14px;
    }

    /* CARD */
    .notif-card {
        background:white;
        padding:20px;
        border-radius:18px;
        box-shadow:0 4px 12px rgba(0,0,0,0.15);
        margin-bottom:20px;
    }

    .notif-title {
        font-size:1rem;
        font-weight:700;
        color:#2A857D;
        margin-bottom:14px;
    }

    .notif-list { padding:0; margin:0; list-style:none; }

    .notif-item {
        padding:14px 0;
        border-bottom:1px solid #eee;
    }

    .notif-item:last-child { border-bottom:none; }

    .notif-type-emergency {
        font-size:.85rem;
        font-weight:700;
        color:#b91c1c;
        display:flex;
        align-items:center;
        gap:6px;
    }

    .notif-type-info {
        font-size:.85rem;
        font-weight:700;
        color:#1d4ed8;
        display:flex;
        align-items:center;
        gap:6px;
    }

    .notif-message {
        margin-top:6px;
        font-size:.9rem;
        color:#333;
        line-height:1.35rem;
    }

    .notif-date {
        font-size:.75rem;
        color:#777;
        margin-top:6px;
    }

    .notif-empty {
        text-align:center;
        padding:20px 0;
        font-size:.9rem;
        color:#777;
    }
</style>

<div class="bg-green">
    <div class="wrap">

        <div class="notif-card">

            <div class="notif-title">Notifikasi</div>

            @if($items->isEmpty())

                <div class="notif-empty">Belum ada notifikasi.</div>

            @else
                <ul class="notif-list">

                    @foreach($items as $n)
                    <li class="notif-item">

                        @if($n->tipe === 'emergency')
                            <div class="notif-type-emergency">🚨 Emergency</div>
                        @else
                            <div class="notif-type-info">ℹ️ Info</div>
                        @endif

                        <div class="notif-message">{{ $n->pesan }}</div>

                        <div class="notif-date">
                            {{ \Carbon\Carbon::parse($n->created_at)->format('d/m/Y H:i') }}
                        </div>

                    </li>
                    @endforeach

                </ul>
            @endif

        </div>

    </div>
</div>

@endsection
