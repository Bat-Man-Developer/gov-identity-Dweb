import sys
import json
import numpy as np
from sklearn.ensemble import IsolationForest

# Read input from stdin
input_data = sys.stdin.read()
logs = json.loads(input_data)

# Prepare data for the model
features = np.array([[
    log['log_id'],
    # Convert date to timestamp
    int(log['log_date'].strftime('%s')),
    hash(log['log_admin_id']),
    hash(log['log_user_id']),
    hash(log['log_action']),
    hash(log['log_status']),
    hash(log['log_location'])
] for log in logs])

# Train the model and predict anomalies
model = IsolationForest(contamination=0.1, random_state=42)
predictions = model.fit_predict(features)

# Identify anomalies
anomalies = []
for i, pred in enumerate(predictions):
    if pred == -1:  # Anomaly detected
        anomaly = logs[i].copy()
        anomaly['anomaly_type'] = 'Unusual activity'
        anomalies.append(anomaly)

# Output results to stdout
print(json.dumps(anomalies))