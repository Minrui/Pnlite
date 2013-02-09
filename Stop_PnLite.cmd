@echo off
nircmd killprocess ~$folder.nircmd$\bin\httpd.exe
if errorlevel 0 Echo  # httpd.exe 已被关闭. && goto killmy
Echo  # httpd.exe 没有运行.
:killmy
nircmd killprocess ~$folder.nircmd$\bin\mysqld-nt.exe
if errorlevel 0 Echo  # mysqld-nt.exe 已被关闭. && goto end
Echo  # mysqld-nt.exe 没有运行.
:end
pause