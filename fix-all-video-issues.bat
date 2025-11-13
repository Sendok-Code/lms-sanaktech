@echo off
cls
color 0A
echo ========================================
echo    VIDEO LEARNING - COMPLETE FIX
echo ========================================
echo.
echo Fixes applied:
echo [x] Video URLs converted to embed (121 videos)
echo [x] JavaScript file created
echo.
echo Remaining manual steps: 2 files to edit
echo.
pause

echo.
echo [1/3] Clearing cache...
call php artisan view:clear
call php artisan cache:clear
call php artisan route:clear
echo ✓ Cache cleared!

echo.
echo [2/3] Checking files...
if exist "public\js\video-learning.js" (
    echo ✓ video-learning.js exists
) else (
    echo ✗ video-learning.js NOT FOUND!
)

if exist "QUICK-FIX-ALL.md" (
    echo ✓ QUICK-FIX-ALL.md exists
) else (
    echo ✗ Documentation NOT FOUND!
)

echo.
echo [3/3] Opening instructions...
start notepad QUICK-FIX-ALL.md

echo.
echo ========================================
echo   NEXT STEPS - MANUAL EDIT (5 MINUTES)
echo ========================================
echo.
echo 1. Edit: app\Http\Controllers\StudentController.php
echo    - Find method updateProgress (line ~181)
echo    - Replace with code from QUICK-FIX-ALL.md
echo.
echo 2. Edit: resources\views\student\courses\learn.blade.php
echo    - Add meta tag in head section
echo    - Include JavaScript file before closing body tag
echo.
echo 3. Refresh browser (Ctrl + F5)
echo.
echo 4. Test video learning!
echo.
echo ========================================
echo.
echo Full instructions opened in Notepad.
echo Follow QUICK-FIX-ALL.md step by step.
echo.
pause
