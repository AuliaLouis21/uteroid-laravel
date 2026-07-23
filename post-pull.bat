@echo off
echo ========================================
echo   Post-Pull Setup - UteroID Laravel
echo ========================================
echo.

echo [1/4] Creating storage link...
php artisan storage:link --force
echo.

echo [2/4] Installing PHP dependencies...
composer install
echo.

echo [3/4] Installing JS dependencies...
npm install
echo.

echo [4/4] Running database migrations...
php artisan migrate
echo.

echo ========================================
echo   Setup selesai! Project siap digunakan.
echo ========================================
pause
