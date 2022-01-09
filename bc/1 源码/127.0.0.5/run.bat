@echo off
if "%1"=="xitong" (
	php %~dp0xitongcaiji.php
)
if "%1"=="api" (
	php %~dp0apicaiji.php
)
if "%1"=="k3" (
	php %~dp0k3.php
)
if "%1"=="kj" (
    php %~dp0openkj.php
)
exit