@echo off
echo ========================================
echo Menjalankan Laravel dengan Ngrok
echo ========================================
echo.
echo Pastikan ngrok sudah terinstall!
echo Download dari: https://ngrok.com/download
echo.
echo Menjalankan Laravel di localhost:8000...
start /B php artisan serve --host=127.0.0.1 --port=8000
timeout /t 3
echo.
echo Menjalankan ngrok tunnel...
echo URL HTTPS akan muncul di bawah:
echo.
ngrok http 8000

