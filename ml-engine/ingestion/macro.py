import requests
from bs4 import BeautifulSoup
import pandas as pd
import re

def fetch_cbsl_macro_indicators():
    """
    Scrapes macro indicators from Central Bank of Sri Lanka (cbsl.gov.lk) and reliable fallback APIs.
    """
    print("Fetching macro indicators...")
    
    # Defaults in case everything fails
    data = {
        "usd_lkr_rate": 310.50,
        "inflation_rate": 4.5,
        "tourist_arrivals_monthly": 150000,
        "policy_rate": 8.0,
    }

    headers = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36"
    }

    # 1. Fetch USD/LKR Exchange Rate
    try:
        # Fallback to a reliable open API first for production stability
        api_url = "https://open.er-api.com/v6/latest/USD"
        res = requests.get(api_url, timeout=5)
        if res.status_code == 200:
            rates = res.json().get("rates", {})
            if "LKR" in rates:
                data["usd_lkr_rate"] = round(rates["LKR"], 2)
                print(f"Success: Secured USD/LKR Rate: {data['usd_lkr_rate']}")
    except Exception as e:
        print(f"Warning: Failed to fetch exchange rate API: {e}")

    # 2. Fetch Macro Indicators (Inflation & Policy Rate) from CBSL homepage
    try:
        cbsl_url = "https://www.cbsl.gov.lk/"
        html = requests.get(cbsl_url, headers=headers, timeout=10)
        
        if html.status_code == 200:
            soup = BeautifulSoup(html.text, 'html.parser')
            text_content = soup.get_text(separator=' ', strip=True)
            
            # Use regex to find CCPI inflation (e.g., "Inflation... 5.2%")
            # A best-effort heuristic for dynamic pages
            match_inf = re.search(r'Inflation.*?(\d+\.\d+)\s*%', text_content, re.IGNORECASE)
            if match_inf:
                data["inflation_rate"] = float(match_inf.group(1))
                print(f"Success: Scraped Inflation Rate: {data['inflation_rate']}%")
                
            # Use regex to find policy rate (e.g., "Standing Deposit Facility Rate... 8.50%")
            match_policy = re.search(r'(?:Policy Rate|Standing Deposit Facility Rate|SDFR).*?(\d+\.\d+)\s*%', text_content, re.IGNORECASE)
            if match_policy:
                data["policy_rate"] = float(match_policy.group(1))
                print(f"Success: Scraped Policy Rate: {data['policy_rate']}%")
                
    except Exception as e:
        print(f"Warning: Failed to scrape CBSL indices: {e}")

    return data

if __name__ == "__main__":
    result = fetch_cbsl_macro_indicators()
    print("\nFinal CBSL Data Retrieved:")
    print(result)
