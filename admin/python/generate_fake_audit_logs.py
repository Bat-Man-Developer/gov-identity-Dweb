import pandas as pd
import random
from datetime import datetime, timedelta

# Original dataset
data = [
    [442, 0, 15, "user view dashboard", "success", "Unknown", "2024-09-29 21:50:53",],
    [443, 6783350, 0, "admin login", "success", "Unknown", "2024-09-29 21:51:45"],
    [444, 0, 0, "admin view dashboard", "failed", "Unknown", "2024-09-29 21:51:46"],
    [445, 6783350, 0, "admin login", "success", "Unknown", "2024-09-29 21:51:54"],
    [446, 0, 14, "user view dashboard", "success", "Unknown", "2024-09-29 21:51:54"],
    [447, 0, 0, "admin register", "failed", "Unknown", "2024-09-29 21:51:55"],
    [448, 6783350, 0, "admin view audit logs", "success", "Unknown", "2024-09-29 21:52:03"],
    [449, 0, 0, "user login", "failed", "Unknown", "2024-09-29 21:52:06"],
    [450, 6783350, 0, "admin view audit logs", "success", "Unknown", "2024-09-29 21:53:45"],
    [451, 6783350, 0, "admin view server id applications", "success", "Unknown", "2024-09-29 21:53:45"],
]

# Create a DataFrame
columns = ["log_id", "admin_id", "user_id", "log_action", "log_status", "log_location", "log_date"]
df = pd.DataFrame(data, columns=columns)

# Function to generate a random datetime within a range
def random_date(start, end):
    return start + timedelta(
        seconds=random.randint(0, int((end - start).total_seconds()))
    )

# List of country locations
locations = [
    "Unknown", "US", "UK", "CA", "AU", "ZA", "DE", "FR", "JP", "CN", "IN", "BR", "MX",
    "ES", "IT", "NL", "RU", "SE", "NO", "DK", "FI", "CH", "AT", "BE", "IE", "NZ", "SG",
    "MY", "TH", "ID", "PH", "VN", "AR", "CL", "CO", "PE", "EG", "SA", "AE", "IL", "TR",
    "PL", "CZ", "HU", "RO", "GR", "PT", "KR", "TW", "HK"
]

# Generate unique rows
start_date = datetime.strptime("2024-09-29 21:50:53", "%Y-%m-%d %H:%M:%S")
end_date = datetime.strptime("2024-09-30 21:50:53", "%Y-%m-%d %H:%M:%S")

unique_rows = []
for i in range(2000):
    row = df.sample(n=1).values[0].tolist()
    row[0] = 452 + i  # Unique Log No.
    row[1] = random.choice([0, 6783350, 6783351, 6783352, 6783353, 6783354])  # Add more admin IDs
    row[2] = random.randint(0, 20)  # Random user ID
    row[4] = random.choice(["success", "failed"])
    row[5] = random.choice(locations)  # Use the expanded list of locations
    row[6] = random_date(start_date, end_date).strftime("%Y-%m-%d %H:%M:%S")
    unique_rows.append(row)

# Create a new DataFrame with unique rows
unique_df = pd.DataFrame(unique_rows, columns=columns)

# Sort by Date
unique_df['log_date'] = pd.to_datetime(unique_df['log_date'])
unique_df = unique_df.sort_values('log_date')

# Reset Log ID to be sequential
unique_df['log_id'] = range(452, 2452)

# Save to CSV
unique_df.to_csv("admin/datasets/audit_logs.csv", index=False)