@echo off
echo ===================================================
echo   System-PITE - Plataforma Inteligente de Turismo
echo ===================================================
echo.
echo 1. Subindo conteineres Docker (App + PostgreSQL)...
docker compose up -d

echo.
echo 2. Executando migracoes do banco de dados...
docker compose exec app php artisan migrate --force

echo.
echo 3. Populando dados iniciais (Seeders)...
docker compose exec app php artisan db:seed --force

echo.
echo ===================================================
echo   System-PITE pronto para acesso!
echo   Acesse no seu navegador: http://localhost:8000
echo ===================================================
echo.
pause
