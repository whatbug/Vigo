@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../hhxsv5/laravel-s/bin/fswatch
bash "%BIN_TARGET%" %*
