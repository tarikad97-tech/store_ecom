@echo off
title Create Project and Open in VS Code

echo ===============================
echo CREATE NEW PROJECT
echo ===============================
echo.

:: demander nom du projet
set /p projectName=Enter project name: 

if "%projectName%"=="" (
echo Project name cannot be empty
pause
exit
)

:: creer structure
mkdir "%projectName%\assets\css"
mkdir "%projectName%\assets\js"
mkdir "%projectName%\assets\img"
mkdir "%projectName%\DB"
mkdir "%projectName%\php"

:: creer index.php
(
echo ^<!DOCTYPE html^>
echo ^<html^>
echo ^<head^>
echo     ^<meta charset="UTF-8"^>
echo     ^<title^>%projectName%^</title^>
echo     ^<link rel="stylesheet" href="assets/css/style.css"^>
echo ^</head^>
echo ^<body^>
echo     ^<h1^>Welcome to %projectName%^</h1^>
echo     ^<script src="assets/js/script.js"^>^</script^>
echo ^</body^>
echo ^</html^>
) > "%projectName%\index.php"

:: creer css et js
type nul > "%projectName%\assets\css\style.css"
type nul > "%projectName%\assets\js\script.js"
type nul > "%projectName%\php\config.php"
echo.
echo Project created successfully!

:: ouvrir VS Code
code "%projectName%"

pause