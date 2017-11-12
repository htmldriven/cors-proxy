@echo off

call %~dp0\..\vendor\bin\tester.bat -s -c %~dp0\..\tests\environment\php-win.ini %~dp0\..\tests -p php
