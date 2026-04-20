@echo off
echo ==============================================
echo   Starting CSE-Predictor 1.0 Environment
echo ==============================================
echo.

echo [1/2] Starting Laravel Backend...
start "Laravel Backend" cmd /k "cd backend && php artisan serve"

echo [2/3] Starting FastAPI ML Engine...
start "FastAPI ML Engine" cmd /k "cd ml-engine && call venv\Scripts\activate && uvicorn main:app --reload --port 8001"

echo [3/3] Starting Vite Frontend Server...
start "Vite Dev Server" cmd /k "cd backend && npm run dev"

echo.
echo All 3 services are now launching in separate windows!
echo You can close this window.
