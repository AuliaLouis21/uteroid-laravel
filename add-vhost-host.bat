@echo off
:: Add utero-group-dev.test to Windows hosts file (run as Administrator)
net session >nul 2>&1
if %errorlevel% neq 0 (
    echo Please run this file as Administrator (right-click ^> Run as administrator).
    pause
    exit /b 1
)
findstr /c:"utero-group-dev.test" C:\Windows\System32\drivers\etc\hosts >nul 2>&1
if %errorlevel% equ 0 (
    echo Entry already exists. Nothing to do.
) else (
    echo 127.0.0.1       utero-group-dev.test      #laragon magic!>> C:\Windows\System32\drivers\etc\hosts
    echo Entry added: 127.0.0.1 utero-group-dev.test
)
ipconfig /flushdns >nul 2>&1
echo Done. Open http://utero-group-dev.test in your browser.
pause
