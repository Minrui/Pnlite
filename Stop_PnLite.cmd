@echo off
nircmd killprocess ~$folder.nircmd$\bin\httpd.exe
if errorlevel 0 Echo  # httpd.exe �ѱ��ر�. && goto killmy
Echo  # httpd.exe û������.
:killmy
nircmd killprocess ~$folder.nircmd$\bin\mysqld-nt.exe
if errorlevel 0 Echo  # mysqld-nt.exe �ѱ��ر�. && goto end
Echo  # mysqld-nt.exe û������.
:end
pause