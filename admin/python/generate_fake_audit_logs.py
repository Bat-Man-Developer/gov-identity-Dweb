import pandas as pd
import random

# Original dataset
data = [
    [442, "2024-09-29 21:50:53", 0, 15, "user view dashboard", "success", "Unknown"],
    [443, "2024-09-29 21:51:45", 6783350, 0, "admin login", "success", "Unknown"],
    [444, "2024-09-29 21:51:46", 0, 0, "admin view dashboard", "failed", "Unknown"],
    [445, "2024-09-29 21:51:54", 6783350, 0, "admin login", "success", "Unknown"],
    [446, "2024-09-29 21:51:54", 0, 14, "user view dashboard", "success", "Unknown"],
    [447, "2024-09-29 21:51:55", 0, 0, "admin register", "failed", "Unknown"],
    [448, "2024-09-29 21:52:03", 6783350, 0, "admin view audit logs", "success", "Unknown"],
    [449, "2024-09-29 21:52:06", 0, 0, "user login", "failed", "Unknown"],
    [450, "2024-09-29 21:53:45", 6783350, 0, "admin view audit logs", "success", "Unknown"],
    [451, "2024-09-29 21:53:45", 6783350, 0, "admin view server id applications", "success", "Unknown"],
]

# Create a DataFrame
columns = ["Log No.", "Date", "Admin", "User", "Action", "Status", "Location"]
df = pd.DataFrame(data, columns=columns)

# Replicate rows to create 100 rows total
replicated_rows = []
for _ in range(100):
    row = df.sample(n=1).values[0]
    replicated_rows.append(row)

# Create a new DataFrame with replicated rows
replicated_df = pd.DataFrame(replicated_rows, columns=columns)

# Save to CSV
replicated_df.to_csv("admin/datasets/audit_logs.csv", index=False)