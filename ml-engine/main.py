from fastapi import FastAPI, BackgroundTasks, HTTPException
from pydantic import BaseModel
from datetime import datetime
import json
import random

try:
    import yfinance as yf
    YFINANCE_AVAILABLE = True
except ImportError:
    YFINANCE_AVAILABLE = False

app = FastAPI(title="CSE-Predictor ML Engine", version="1.0.0")

# Request / Response Schemas
class PredictRequest(BaseModel):
    symbol: str
    target_date: str | None = None

class PredictResponse(BaseModel):
    symbol: str
    predicted_price: float
    confidence: float
    model_used: str

class RetrainRequest(BaseModel):
    symbol: str

@app.get("/")
def read_root():
    return {"status": "ok", "service": "CSE-Predictor API"}

@app.get("/health")
def health_check():
    return {
        "status": "healthy",
        "timestamp": datetime.now().isoformat(),
        "drift_detected": False # Placeholder for actual drift monitoring
    }

@app.post("/predict", response_model=PredictResponse)
def predict_stock(req: PredictRequest):
    symbol_cm = f"{req.symbol}.CM"
    
    # 1. Fetch live market price
    try:
        if YFINANCE_AVAILABLE:
            ticker = yf.Ticker(symbol_cm)
            history = ticker.history(period="1d")
            if not history.empty:
                current_price = history['Close'].iloc[-1]
            else:
                current_price = 110.00 # Fallback 
        else:
            # Fallback if module is missing
            current_price = 110.00 # Base simulated fallback
    except Exception as e:
        print(f"fetch error: {e}")
        current_price = 110.00 # Fallback

    # 2. Dynamic Integration using basic arithmetic sim
    banking = ['COMB', 'HNB', 'SAMP', 'NDB', 'LOLC']
    staples = ['CARG', 'KEEGH', 'CTC', 'LION', 'HHL']
    
    # Simulate an ML inference: adding a randomized slight curve (+/- 3%)
    volatility_factor = random.uniform(0.97, 1.03)
    predicted_value = round(current_price * volatility_factor, 2)
    
    if req.symbol in banking:
        model_name = "LSTM (Short-term Volatility)"
    elif req.symbol in staples:
        model_name = "OLS Regression"
    else:
        model_name = "RandomForest (Volatility Fallback)"
        
    # Example confidence curve mapping
    confidence = round(random.uniform(0.78, 0.92), 2)
        
    return PredictResponse(
        symbol=req.symbol,
        predicted_price=predicted_value,
        confidence=confidence,
        model_used=model_name
    )

@app.post("/retrain")
def trigger_retrain(req: RetrainRequest, background_tasks: BackgroundTasks):
    # Setup background task simulating model retraining
    def train_model(sym: str):
        print(f"[{datetime.now()}] Starting retraining for {sym}...")
        import time
        time.sleep(3)
        print(f"[{datetime.now()}] Retraining completed for {sym}.")

    background_tasks.add_task(train_model, req.symbol)
    return {"message": f"Retraining task for {req.symbol} queued successfully."}
