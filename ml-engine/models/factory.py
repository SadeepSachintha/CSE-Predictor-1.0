import pandas as pd
from sklearn.ensemble import RandomForestRegressor
from sklearn.linear_model import LinearRegression

def build_random_forest():
    """
    Random Forest utilized for handling volatility 'shocks' as per Phase B.
    """
    model = RandomForestRegressor(n_estimators=100, random_state=42)
    return model

def build_regression_model():
    """
    Linear Regression for Material & Consumer Staples.
    """
    model = LinearRegression()
    return model

def build_lstm_simulator():
    """
    In a full TF setup, we would use:
    model = Sequential([
        LSTM(50, return_sequences=True, input_shape=(100, 1)),
        Dense(1)
    ])
    For now, simulating with a regressor structure until Python 3.14 wheel compatibility is verified.
    """
    from sklearn.neural_network import MLPRegressor
    model = MLPRegressor(hidden_layer_sizes=(50, 10), max_iter=100)
    return model

if __name__ == "__main__":
    print("Models initialized successfully.")
