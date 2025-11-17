<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>HEALTH SYNC - Dashboard Pengasuh</title>
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

        /* Header */
        .header {
            background-color: #2A857D;
            color: white;
            padding: 1rem;
            text-align: center;
            font-weight: bold;
            font-size: 1.2rem;
            letter-spacing: 1px;
        }

        /* Emergency Button */
        .emergency-btn {
            background-color: #F5F5F5;
            border: none;
            border-radius: 12px;
            padding: 1rem;
            margin: 1rem;
            width: calc(100% - 2rem);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
            text-align: center;
            font-weight: bold;
            font-size: 1rem;
            color: #D32F2F;
            text-transform: uppercase;
        }

        .emergency-btn:active {
            transform: scale(0.98);
        }

        /* Section */
        .section {
            margin: 1.5rem 1rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .section-title {
            font-weight: 600;
            font-size: 1rem;
            color: #000;
        }

        .section-icon {
            width: 24px;
            height: 24px;
            cursor: pointer;
        }

        .divider {
            height: 1px;
            background-color: #D1D5DB;
            margin: 0.5rem 0;
        }

        .content-box {
            background-color: white;
            border-radius: 12px;
            padding: 1rem;
            margin-top: 0.5rem;
            min-height: 150px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .content-box.empty {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9CA3AF;
            font-size: 0.9rem;
        }

        /* Bottom Navigation */
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

        /* Icon Styles */
        .icon-plus {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'/%3E%3C/svg%3E");
            background-size: contain;
            cursor: pointer;
        }

        .icon-checklist {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23000'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'/%3E%3C/svg%3E");
            background-size: contain;
            cursor: pointer;
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

        /* Alert */
        .alert {
            padding: 0.75rem;
            margin: 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #D1FAE5;
            color: #065F46;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        HEALTH SYNC
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div style="background-color: #FEF3C7; color: #92400E; padding: 0.75rem; margin: 1rem; border-radius: 8px; font-size: 0.9rem;">
            {{ session('warning') }}
        </div>
    @endif

    <!-- Emergency Button -->
    <form action="{{ route('pengasuh.kirim-notifikasi-darurat-langsung') }}" method="POST" style="margin: 1rem;">
        @csrf
        <button type="submit" class="emergency-btn" onclick="return confirm('Kirim notifikasi darurat ke tenaga medis dan keluarga?')">
            🚨 KONDISI DARURAT
        </button>
    </form>

    <!-- Riwayat Kondisi Lansia Section -->
    <div class="section">
        <div class="section-header">
            <span class="section-title">RIWAYAT KONDISI LANSIA</span>
            <span class="icon-plus" onclick="window.location.href='{{ route('pengasuh.riwayat') }}'"></span>
        </div>
        <div class="divider"></div>
        <div class="content-box">
            @if($lansia->count() > 0)
                <div style="padding: 0.5rem 0;">
                    <p style="font-weight: 600; margin-bottom: 0.5rem;">Pilih lansia untuk melihat riwayat:</p>
                    @foreach($lansia->take(3) as $l)
                        <div style="padding: 0.5rem; background: #F9FAFB; border-radius: 8px; margin-bottom: 0.5rem;">
                            <strong>{{ $l->nama_lansia }}</strong> ({{ $l->id_lansia }})
                        </div>
                    @endforeach
                    @if($lansia->count() > 3)
                        <p style="color: #6B7280; font-size: 0.85rem; margin-top: 0.5rem;">+ {{ $lansia->count() - 3 }} lansia lainnya</p>
                    @endif
                </div>
            @else
                <div class="empty">Belum ada data lansia</div>
            @endif
        </div>
    </div>

    <!-- Update Kondisi Lansia Section -->
    <div class="section">
        <div class="section-header">
            <span class="section-title">UPDATE KONDISI LANSIA</span>
            <span class="icon-checklist" onclick="window.location.href='{{ route('pengasuh.update-kondisi') }}'"></span>
        </div>
        <div class="divider"></div>
        <div class="content-box">
            <div style="padding: 0.5rem 0;">
                <p style="color: #6B7280; font-size: 0.9rem;">Klik icon di atas untuk menambah atau memperbarui kondisi lansia</p>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
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

