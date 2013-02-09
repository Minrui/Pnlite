@echo off
nircmd exec hide bin\httpd.exe || pause && Exit
Echo  # PHPnow-Lite 正在运行.
Pause
rem start http://127.1:81/