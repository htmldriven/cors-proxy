@echo off

call %~dp0\..\vendor\bin\phpcs.bat -p --standard=PSR2 %~dp0\..\src %~dp0\..\tests
