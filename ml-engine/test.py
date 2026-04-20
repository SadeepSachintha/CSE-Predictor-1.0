import yfinance as yf
ticker = yf.Ticker('COMB.CM')
hist = ticker.history(period='1d')
if not hist.empty:
    print(hist.iloc[-1].to_dict())
else:
    print('Empty')
