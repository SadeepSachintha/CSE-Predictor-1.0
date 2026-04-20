# CSE-Predictor 1.0

A comprehensive, hybrid stock market prediction pipeline for the Colombo Stock Exchange (CSE).

## Overview
CSE-Predictor 1.0 combines a robust Laravel backend with a high-performance Python/FastAPI Machine Learning engine. It provides investors with actionable insights through real-time stock trend predictions and "Hot Zone" analysis, all presented in a premium, dark-themed dashboard. 

## Key Features
- **Hybrid Architecture:** Seamless integration between a Laravel PHP web application and a Python-based ML FastAPI engine.
- **Interactive Trading Charts:** Professional-grade, highly responsive stock charting using TradingView Lightweight Charts (Candlestick & Line views).
- **Live Data via WebSockets:** Real-time stock data broadcast directly to the dashboard without page refreshes, powered by Laravel Reverb.
- **Personalized Watchlists:** Secure, user-specific stock pinning functionality to quickly monitor favorite tickers.
- **Real-Time Data Integration:** Ingestion of live CSE market data, alongside vital macroeconomic indicators (USD/LKR exchange rate, CCPI inflation rate, policy rates) directly from the Central Bank of Sri Lanka (CBSL).
- **Advanced Machine Learning:** Utilizes Long Short-Term Memory (LSTM) and Random Forest models for accurate stock movement predictions.
- **MLOps Capabilities:** Built-in drift detection and automated retraining pipelines to ensure sustained model accuracy over time.
- **Premium Dashboard Interface:** A highly responsive, custom-designed dark UI featuring glowing visual aesthetics and custom stock icons.
- **Hot Zone Analysis:** Visual identification and alerts for critical stock movements and high-opportunity investment zones.
- **Secure Access:** Role-based authentication ensuring secure access to personal portfolios and system administration.

## Technology Stack
- **Backend/Middle:** Laravel 12, PHP, MySQL, Laravel Reverb (WebSockets)
- **Frontend UI:** Blade Templates, Tailwind CSS, Alpine.js, TradingView Lightweight Charts
- **ML Engine:** Python, FastAPI, Pandas, Scikit-Learn
- **Data Sourcers:** CSE Market Pipelines, CBSL Scrapers

## Project Structure
- `/backend`: Contains the main Laravel application, including the web views, UI components, authentication, and the dashboard frontend.
- `/ml-engine`: Contains the Python machine learning code, data ingesters, FastAPI endpoints, and model training pipelines.

## Setup Instructions

### Quick Start (Windows)
We have provided a convenient batch script to launch the complete environment automatically. 
1. Open your terminal (PowerShell or Command Prompt).
2. Navigate to the root directory `CSE-Predictor 1.0`.
3. Run the unified startup script:
   ```cmd
   .\start_predictor.bat
   ```
Both the Laravel Dashboard and the Python ML Engine will launch in their own dedicated windows automatically. *(Note: The ML engine explicitly runs on port 8001 as required by the Laravel backend).*

---

### Manual Setup

#### Prerequisites
- PHP 8.x and Composer
- Node.js and npm
- Python 3.9+ 

### 1. Web Application (Laravel Backend)
1. Navigate to the `backend` directory:
   ```bash
   cd backend
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install and compile frontend assets:
   ```bash
   npm install && npm run dev
   ```
4. Copy `.env.example` to `.env` and configure your database settings.
5. Generate an application key:
   ```bash
   php artisan key:generate
   ```
6. Run database migrations:
   ```bash
   php artisan migrate
   ```
7. Start the development server:
   ```bash
   php artisan serve
   ```

### 2. Machine Learning Engine (FastAPI)
1. Navigate to the `ml-engine` directory:
   ```bash
   cd ml-engine
   ```
2. Create and activate a Python virtual environment:
   ```bash
   python -m venv venv
   # On Windows:
   venv\Scripts\activate
   # On macOS/Linux:
   source venv/bin/activate
   ```
3. Install the required packages:
   ```bash
   pip install -r requirements.txt
   ```
4. Start the FastAPI server (typically via Uvicorn):
   ```bash
   uvicorn main:app --reload
   ```

## Recent Updates
- Resolved chart rendering issues by refactoring the TradingView Lightweight Charts initialization to support the v5 modular API.
- Integrated **TradingView Lightweight Charts** for professional, interactive price mapping on the dashboard.
- Configured **Laravel Reverb WebSockets** for instantaneous, zero-refresh live market data streaming.
- Built **Interactive Watchlists** allowing users to pin and unpin stocks directly from the dashboard.
- Modernized dashboard visuals with tailored, high-fidelity SVGs and glowing dark-mode aesthetics.
- Established a real-time data pipeline for live market values and automated macroeconomic indicator scrapers (CBSL).
