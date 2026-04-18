from fastapi import FastAPI, BackgroundTasks, HTTPException
from pydantic import BaseModel
from datetime import datetime
import json

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
    # Sector-based Model Selection Mock
    banking = ['COMB', 'HNB']
    staples = ['CARG', 'KEEGH']
    
    predicted_value = 0.0
    model_name = "RandomForest (Volatility Fallback)"
    
    if req.symbol in banking:
        model_name = "LSTM (Mock)"
        predicted_value = 125.50 # Mock value based on recent COMB prices
    elif req.symbol in staples:
        model_name = "OLS Regression"
        predicted_value = 85.20
    else:
        predicted_value = 50.00
        
    return PredictResponse(
        symbol=req.symbol,
        predicted_price=predicted_value,
        confidence=0.85,
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
