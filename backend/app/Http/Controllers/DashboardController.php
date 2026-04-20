<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use App\Models\PredictionLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // "Hot Zones" hardcoded for the dashboard view based on user requirements for April 2026
        $hotZones = [
            ['sector' => 'Consumer Staples', 'outlook' => 'Bullish', 'note' => 'Leading recent 7-day gains (+3.8%).'],
            ['sector' => 'Renewable Energy', 'outlook' => 'Trending', 'note' => 'Identified as a high-growth industry for the mid-year.'],
            ['sector' => 'Tourism/Hotels', 'outlook' => 'Recovery Play', 'note' => 'Aiming for $4.5B revenue in 2026; infrastructure is stable.'],
            ['sector' => 'Banking', 'outlook' => 'Stable/Dividends', 'note' => 'Dialog (DIAL) recently increased dividends to Rs. 1.50.'],
        ];

        $marketWatchData = [];
        try {
            $response = Http::timeout(8)->get('http://127.0.0.1:8001/market-watch');
            if ($response->successful()) {
                $marketWatchData = $response->json()['data'] ?? [];
            }
        } catch (\Exception $e) {
            // Fails silently for the dashboard load if ML engine is off
            $marketWatchData = [];
        }

        return view('dashboard', compact('hotZones', 'marketWatchData'));
    }

    public function predict(Request $request)
    {
        $request->validate([
            'symbol' => 'required|string|max:10'
        ]);

        $symbol = strtoupper($request->symbol);

        try {
            $response = Http::post('http://127.0.0.1:8001/predict', [
                'symbol' => $symbol,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Log prediction
                PredictionLog::create([
                    'symbol' => $data['symbol'],
                    'predicted_price' => $data['predicted_price'],
                    'confidence' => $data['confidence'],
                    'model_used' => $data['model_used']
                ]);

                return back()->with('prediction', $data);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['ml_engine' => 'Failed to connect to the ML Engine (Python). Please ensure the FastAPI service is running.']);
        }

        return back()->withErrors(['ml_engine' => 'Invalid response from ML Engine.']);
    }
}
