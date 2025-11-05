@echo off
echo ========================================
echo   VERIFICANDO ESTADO DE SERVICIOS
echo ========================================
echo.

echo [1/3] Verificando servidor Laravel (puerto 8080)...
netstat -an | findstr ":8080" > nul
if %errorlevel% equ 0 (
    echo     [OK] Servidor Laravel esta corriendo en http://localhost:8080
) else (
    echo     [X] Servidor Laravel NO esta corriendo
)
echo.

echo [2/3] Verificando Vite dev server (puerto 5173)...
netstat -an | findstr ":5173" > nul
if %errorlevel% equ 0 (
    echo     [OK] Vite dev server esta corriendo en http://localhost:5173
) else (
    echo     [X] Vite dev server NO esta corriendo
)
echo.

echo [3/3] Verificando MySQL (puerto 3306/3307)...
netstat -an | findstr ":3306" > nul
if %errorlevel% equ 0 (
    echo     [OK] MySQL esta corriendo en puerto 3306
) else (
    netstat -an | findstr ":3307" > nul
    if %errorlevel% equ 0 (
        echo     [OK] MySQL esta corriendo en puerto 3307
    ) else (
        echo     [X] MySQL NO esta corriendo
    )
)

echo.
echo ========================================
echo   FIN DE VERIFICACION
echo ========================================
echo.
pause
