@echo off
echo ========================================
echo   VIDEO LEARNING FIX - INSTALLER
echo ========================================
echo.
echo This script will apply all necessary fixes for video learning feature.
echo.
pause

echo.
echo [1/3] Clearing cache...
php artisan view:clear
php artisan cache:clear
php artisan route:clear

echo.
echo [2/3] Checking files...
if exist "public\js\video-learning.js" (
    echo ✓ video-learning.js exists
) else (
    echo ✗ video-learning.js NOT FOUND!
    echo Please create the file manually.
)

echo.
echo [3/3] Instructions:
echo.
echo MANUAL STEPS REQUIRED:
echo.
echo 1. Edit app\Http\Controllers\StudentController.php
echo    - Find method updateProgress (line ~181)
echo    - Replace with code from VIDEO-LEARNING-FIX.md
echo.
echo 2. Edit resources\views\student\courses\learn.blade.php
echo    - Add meta tag in head section
echo    - Include JavaScript file before closing body tag
echo.
echo 3. Open VIDEO-LEARNING-FIX.md for complete instructions
echo.
echo ========================================
echo   DONE!
echo ========================================
echo.
echo Please follow the manual steps in VIDEO-LEARNING-FIX.md
echo.
pause
