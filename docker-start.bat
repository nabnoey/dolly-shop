@echo off
REM Doll Shop Docker Helper for Windows
REM Requires: Docker Desktop installed on Windows

cls
echo.
echo =================================================
echo    Doll Shop - Docker Management
echo =================================================
echo.
echo 1. Start Containers (docker-compose up)
echo 2. Stop Containers (docker-compose down)
echo 3. View Logs (docker-compose logs)
echo 4. Restart Containers
echo 5. Rebuild Images (docker-compose up --build)
echo 6. Open Applications in Browser
echo 7. Execute SQL Query
echo 8. Exit
echo.
set /p choice="Select option (1-8): "

if "%choice%"=="1" goto start
if "%choice%"=="2" goto stop
if "%choice%"=="3" goto logs
if "%choice%"=="4" goto restart
if "%choice%"=="5" goto rebuild
if "%choice%"=="6" goto open_browser
if "%choice%"=="7" goto exec_sql
if "%choice%"=="8" goto end

echo Invalid choice. Please try again.
timeout /t 2 > nul
goto menu

:start
cls
echo.
echo Starting Docker containers...
docker-compose up -d
echo.
echo ✓ Containers started!
echo.
echo Access the application at:
echo   - Web: http://localhost
echo   - Admin: http://localhost/admin
echo   - phpMyAdmin: http://localhost:8080
echo.
pause
goto menu

:stop
cls
echo.
echo Stopping Docker containers...
docker-compose down
echo.
echo ✓ Containers stopped!
echo.
pause
goto menu

:logs
cls
echo.
echo Showing docker logs...
docker-compose logs -f
goto menu

:restart
cls
echo.
echo Restarting Docker containers...
docker-compose restart
echo.
echo ✓ Containers restarted!
echo.
pause
goto menu

:rebuild
cls
echo.
echo Rebuilding Docker images (this may take a while)...
docker-compose up -d --build
echo.
echo ✓ Images rebuilt and containers started!
echo.
pause
goto menu

:open_browser
cls
echo.
echo Opening applications in browser...
timeout /t 2 > nul
start http://localhost
echo.
echo Waiting 2 seconds...
timeout /t 2 > nul
start http://localhost:8080
echo.
echo ✓ Applications opened!
echo.
pause
goto menu

:exec_sql
cls
echo.
echo Available commands:
echo   1. Initialize Database (init_db.php)
echo   2. MySQL CLI
echo.
set /p sql_choice="Select (1-2): "

if "%sql_choice%"=="1" (
    echo.
    echo Opening init_db.php in browser...
    start http://localhost/includes/init_db.php
) else if "%sql_choice%"=="2" (
    echo.
    echo Connecting to MySQL...
    docker exec -it doll-shop-mysql mysql -u root -proot doll_shop
)
goto menu

:end
echo.
echo Goodbye!
echo.
exit /b 0

:menu
cls
echo.
echo =================================================
echo    Doll Shop - Docker Management
echo =================================================
echo.
echo 1. Start Containers (docker-compose up)
echo 2. Stop Containers (docker-compose down)
echo 3. View Logs (docker-compose logs)
echo 4. Restart Containers
echo 5. Rebuild Images (docker-compose up --build)
echo 6. Open Applications in Browser
echo 7. Execute SQL Query
echo 8. Exit
echo.
set /p choice="Select option (1-8): "

if "%choice%"=="1" goto start
if "%choice%"=="2" goto stop
if "%choice%"=="3" goto logs
if "%choice%"=="4" goto restart
if "%choice%"=="5" goto rebuild
if "%choice%"=="6" goto open_browser
if "%choice%"=="7" goto exec_sql
if "%choice%"=="8" goto end

echo Invalid choice. Please try again.
timeout /t 2 > nul
goto menu
