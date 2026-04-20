import { createChart, ColorType, CandlestickSeries, LineSeries } from 'lightweight-charts';

const initLiveChart = () => {
    const chartContainer = document.getElementById('tv-chart');
    if (!chartContainer) return;

    // Create the chart with a beautiful dark theme matching the dashboard
    const chart = createChart(chartContainer, {
        autoSize: true,
        height: 400,
        layout: {
            background: { type: ColorType.Solid, color: 'transparent' },
            textColor: '#9CA3AF', // Tailwind gray-400
        },
        grid: {
            vertLines: { color: 'rgba(55, 65, 81, 0.5)' }, // Tailwind gray-700
            horzLines: { color: 'rgba(55, 65, 81, 0.5)' },
        },
        crosshair: {
            mode: 1, // Normal crosshair
        },
        rightPriceScale: {
            borderColor: 'rgba(55, 65, 81, 1)',
        },
        timeScale: {
            borderColor: 'rgba(55, 65, 81, 1)',
            timeVisible: true,
        },
    });

    // Initial Candlestick Series
    let series = chart.addSeries(CandlestickSeries, {
        upColor: '#10B981', // Emerald 500
        downColor: '#EF4444', // Red 500
        borderVisible: false,
        wickUpColor: '#10B981',
        wickDownColor: '#EF4444',
    });

    // Mock initial data (since real historical data needs an API)
    // We'll generate some semi-realistic looking stock data for the last 50 days
    const mockData = [];
    let basePrice = 120;
    const now = new Date();
    now.setHours(0, 0, 0, 0);

    for (let i = 50; i >= 0; i--) {
        const time = new Date(now.getTime() - i * 24 * 60 * 60 * 1000);
        // skip weekends
        if (time.getDay() === 0 || time.getDay() === 6) continue;
        
        const open = basePrice + (Math.random() - 0.5) * 5;
        const close = open + (Math.random() - 0.5) * 6;
        const high = Math.max(open, close) + Math.random() * 2;
        const low = Math.min(open, close) - Math.random() * 2;
        
        const timeStr = time.getFullYear() + '-' + String(time.getMonth() + 1).padStart(2, '0') + '-' + String(time.getDate()).padStart(2, '0');
        
        mockData.push({
            time: timeStr,
            open, high, low, close
        });
        basePrice = close;
    }
    
    series.setData(mockData);

    // Switch between Line and Candlestick
    const btnLine = document.getElementById('btn-line');
    const btnCandle = document.getElementById('btn-candlestick');

    if (btnLine && btnCandle) {
        btnLine.addEventListener('click', () => {
            chart.removeSeries(series);
            series = chart.addSeries(LineSeries, {
                color: '#3B82F6', // Blue 500
                lineWidth: 2,
                crosshairMarkerVisible: true,
                crosshairMarkerRadius: 6,
            });
            // Convert candle data to line data tracking the close price
            const lineData = mockData.map(d => ({ time: d.time, value: d.close }));
            series.setData(lineData);
            
            btnLine.className = "px-3 py-1 bg-blue-600 hover:bg-blue-500 text-xs font-semibold rounded text-white transition-colors";
            btnCandle.className = "px-3 py-1 bg-gray-700 hover:bg-gray-600 text-xs font-semibold rounded text-white transition-colors";
        });

        btnCandle.addEventListener('click', () => {
            chart.removeSeries(series);
            series = chart.addSeries(CandlestickSeries, {
                upColor: '#10B981',
                downColor: '#EF4444',
                borderVisible: false,
                wickUpColor: '#10B981',
                wickDownColor: '#EF4444',
            });
            series.setData(mockData);
            
            btnCandle.className = "px-3 py-1 bg-blue-600 hover:bg-blue-500 text-xs font-semibold rounded text-white transition-colors";
            btnLine.className = "px-3 py-1 bg-gray-700 hover:bg-gray-600 text-xs font-semibold rounded text-white transition-colors";
        });
    }
    
    // Expose chart to window for WebSockets later
    window.tvChart = chart;
    window.tvSeries = series;

    // Listen for real-time WebSocket events from Laravel Reverb
    if (window.Echo) {
        window.Echo.channel('market-data')
            .listen('StockPriceUpdated', (e) => {
                const newStockData = e.stockData;
                
                // Assuming data contains { time, open, high, low, close }
                if (window.tvSeries && newStockData.time && newStockData.close) {
                    window.tvSeries.update({
                        time: typeof newStockData.time === 'string' ? new Date(newStockData.time).getTime() / 1000 : newStockData.time,
                        open: newStockData.open || newStockData.close,
                        high: newStockData.high || newStockData.close,
                        low: newStockData.low || newStockData.close,
                        close: newStockData.close,
                        value: newStockData.close // for Line chart fallback
                    });
                }
            });
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLiveChart);
} else {
    initLiveChart();
}
