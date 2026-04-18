import requests
from bs4 import BeautifulSoup
import pandas as pd

def fetch_cbsl_macro_indicators():
    """
    Mock scraper representing a connection to the Central Bank of Sri Lanka (cbsl.gov.lk).
    In a fully operational system, we'd parse exchange rates and inflation directly from their stats API/tables.
    """
    print("Fetching macro indicators from Central Bank of Sri Lanka...")
    # Mock data return for 2026 scenarios
    return {
        "usd_lkr_rate": 310.50,
        "inflation_rate": 4.5,
        "tourist_arrivals_monthly": 150000,
        "policy_rate": 8.0,
    }

if __name__ == "__main__":
    data = fetch_cbsl_macro_indicators()
    print("Recent CBSL Data:", data)
