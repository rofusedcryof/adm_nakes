<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>HEALTH SYNC - Kondisi Darurat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #E5E5E5;
            min-height: 100vh;
            padding-bottom: 80px;
        }

        .header {
            background-color: #2A857D;
            color: white;
            padding: 1rem;
            text-align: center;
            font-weight: bold;
            font-size: 1.2rem;
            letter-spacing: 1px;
            position: relative;
        }

        .back-btn {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .container {
            padding: 1rem;
        }

        .alert-item {
            background-color: white;
            border-left: 4px solid #D32F2F;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .alert-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .alert-lansia {
            font-weight: 600;
            color: #D32F2F;
            font-size: 1.1rem;
        }

        .alert-date {
            font-size: 0.85rem;
            color: #6B7280;
        }

        .alert-body {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }

        .alert-value {
            padding: 0.5rem;
            background-color: #FEE2E2;
            border-radius: 6px;
        }

        .alert-label {
            font-size: 0.8rem;
            color: #6B7280;
            margin-bottom: 0.25rem;
        }

        .alert-value-text {
            font-weight: 600;
            color: #D32F2F;
            font-size: 1rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #9CA3AF;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0.75rem 0;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #000;
            flex: 1;
        }

        .nav-item.active {
            color: #2A857D;
        }

        .nav-icon {
            width: 24px;
            height: 24px;
            margin-bottom: 0.25rem;
        }

        .icon-home {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%232A857D'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'/%3E%3C/svg%3E");
            background-size: contain;
        }

        .icon-bell {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'/%3E%3C/svg%3E");
            background-size: contain;
        }

        .icon-profile {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23000'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E");
            background-size: contain;
        }

        .btn-kirim-notifikasi {
            width: 100%;
            background-color: #D32F2F;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-weight: bold;
            font-size: 0.9rem;
            cursor: pointer;
            text-transform: uppercase;
            transition: background-color 0.2s;
        }

        .btn-kirim-notifikasi:hover {
            background-color: #B71C1C;
        }

        .btn-kirim-notifikasi:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-btn" onclick="window.location.href='{{ route('pengasuh.dashboard') }}'">←</button>
        KONDISI DARURAT
    </div>

    <div class="container">
        @if(session('success'))
            <div style="background-color: #D1FAE5; color: #065F46; padding: 0.75rem; margin: 1rem; border-radius: 8px; font-size: 0.9rem;">
                {{ session('success') }}
            </div>
        @endif

        @if($kondisiDarurat->count() > 0)
            @foreach($kondisiDarurat as $kondisi)
                <div class="alert-item">
                    <div class="alert-header">
                        <span class="alert-lansia">{{ $kondisi->lansia->nama_lansia }}</span>
                        <span class="alert-date">{{ $kondisi->diukur_pada->format('d/m/Y H:i') }}</span>
                    </div>
                    <form action="{{ route('pengasuh.kirim-notifikasi-darurat') }}" method="POST" style="margin-top: 1rem;">
                        @csrf
                        <input type="hidden" name="kondisi_id" value="{{ $kondisi->id }}">
                        <input type="hidden" name="lansia_id" value="{{ $kondisi->lansia_id }}">
                        <button type="submit" class="btn-kirim-notifikasi" onclick="return confirm('Kirim notifikasi darurat ke tenaga medis dan keluarga?')">
                            🚨 KIRIM NOTIFIKASI DARURAT
                        </button>
                    </form>
                    <div class="alert-body">
                        @if($kondisi->sistol && ($kondisi->sistol > 180 || $kondisi->sistol < 90))
                            <div class="alert-value">
                                <div class="alert-label">Tekanan Darah Sistol</div>
                                <div class="alert-value-text">{{ $kondisi->sistol }} mmHg</div>
                            </div>
                        @endif
                        @if($kondisi->diastol && ($kondisi->diastol > 120 || $kondisi->diastol < 60))
                            <div class="alert-value">
                                <div class="alert-label">Tekanan Darah Diastol</div>
                                <div class="alert-value-text">{{ $kondisi->diastol }} mmHg</div>
                            </div>
                        @endif
                        @if($kondisi->nadi && ($kondisi->nadi > 100 || $kondisi->nadi < 60))
                            <div class="alert-value">
                                <div class="alert-label">Nadi</div>
                                <div class="alert-value-text">{{ $kondisi->nadi }} bpm</div>
                            </div>
                        @endif
                        @if($kondisi->suhu && ($kondisi->suhu > 38.5 || $kondisi->suhu < 36.0))
                            <div class="alert-value">
                                <div class="alert-label">Suhu</div>
                                <div class="alert-value-text">{{ $kondisi->suhu }}°C</div>
                            </div>
                        @endif
                        @if($kondisi->gula_darah && ($kondisi->gula_darah > 200 || $kondisi->gula_darah < 70))
                            <div class="alert-value">
                                <div class="alert-label">Gula Darah</div>
                                <div class="alert-value-text">{{ $kondisi->gula_darah }} mg/dL</div>
                            </div>
                        @endif
                    </div>
                    @if($kondisi->catatan)
                        <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #E5E7EB;">
                            <div style="font-size: 0.85rem; color: #6B7280; margin-bottom: 0.25rem;">Catatan</div>
                            <div style="color: #000; font-size: 0.9rem;">{{ $kondisi->catatan }}</div>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">✓</div>
                <p>Tidak ada kondisi darurat saat ini</p>
            </div>
        @endif
    </div>

    <div class="bottom-nav">
        <a href="{{ route('pengasuh.dashboard') }}" class="nav-item active">
            <span class="icon-home"></span>
            <span style="font-size: 0.75rem;">Home</span>
        </a>
        <a href="#" class="nav-item">
            <span class="icon-bell"></span>
            <span style="font-size: 0.75rem;">Notifikasi</span>
        </a>
        <a href="#" class="nav-item">
            <span class="icon-profile"></span>
            <span style="font-size: 0.75rem;">Profile</span>
        </a>
    </div>
</body>
</html>

