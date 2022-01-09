@echo off
start  %~dp0run.bat api
start  %~dp0run.bat xitong
start  %~dp0run.bat k3
start  %~dp0run.bat kj
choice /t 10 /d y /n >nul
start  %~dp0auto.bat
 exit