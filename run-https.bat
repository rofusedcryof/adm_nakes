@echo off
echo ========================================
echo Menjalankan Laravel dengan HTTPS
echo ========================================
echo.

REM Generate self-signed certificate jika belum ada
if not exist "server.crt" (
    echo Membuat sertifikat SSL self-signed...
    openssl req -x509 -newkey rsa:4096 -keyout server.key -out server.crt -days 365 -nodes -subj "/CN=192.168.1.73"
    echo Sertifikat berhasil dibuat!
    echo.
)

REM Jalankan PHP dengan HTTPS
echo Menjalankan server di https://192.168.1.73:8000
echo Tekan Ctrl+C untuk menghentikan
echo.
php -S 192.168.1.73:8000 -t public server.php

