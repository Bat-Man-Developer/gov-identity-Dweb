import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
import os
from sklearn.cluster import KMeans
from sklearn.preprocessing import StandardScaler
from sklearn.impute import SimpleImputer

# Define the file path to your CSV file
file_path = 'c:/Xampp/htdocs/gov-identity-Dweb/admin/datasets/audit_logs.csv'

# Load the data
df = pd.read_csv(file_path, sep=',')

# Convert Date to datetime
df['Date'] = pd.to_datetime(df['Date'])

# Extract features for clustering
df['Hour'] = df['Date'].dt.hour
df['Minute'] = df['Date'].dt.minute
df['Second'] = df['Date'].dt.second

# Encode categorical variables
df['Action_encoded'] = pd.factorize(df['Action'])[0]
df['Status_encoded'] = pd.factorize(df['Status'])[0]

# Select features for clustering
features = ['Hour', 'Minute', 'Second', 'Admin', 'User', 'Action_encoded', 'Status_encoded']

# Create a copy of the features for clustering
X = df[features].copy()

# Impute missing values
imputer = SimpleImputer(strategy='mean')
X = pd.DataFrame(imputer.fit_transform(X), columns=X.columns)

# Normalize the features
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# Create directory for saving plots
plot_dir = 'c:/Xampp/htdocs/gov-identity-Dweb/admin/model_plots'
os.makedirs(plot_dir, exist_ok=True)

# Elbow Method for finding optimal number of clusters
inertia = []
k_range = range(1, 11)  # Testing from 1 to 10 clusters
for k in k_range:
    kmeans = KMeans(n_clusters=k, random_state=42)
    kmeans.fit(X_scaled)
    inertia.append(kmeans.inertia_)

# Plot the Elbow Method
plt.figure(figsize=(10, 6))
plt.plot(k_range, inertia, marker='o')
plt.title('Elbow Method For Optimal k')
plt.xlabel('Number of clusters')
plt.ylabel('Inertia')
plt.xticks(k_range)
plt.grid()
plt.savefig(os.path.join(plot_dir, 'elbow_method.png'))
plt.close()

# Perform K-means clustering with the chosen number of clusters
n_clusters = 3  # Adjust based on elbow method
kmeans = KMeans(n_clusters=n_clusters, random_state=42)
df['Cluster'] = kmeans.fit_predict(X_scaled)

# Calculate the distance of each point to its cluster center
df['Distance'] = np.min(kmeans.transform(X_scaled), axis=1)

# Define anomalies as points that are far from their cluster center
threshold = df['Distance'].mean() + 2 * df['Distance'].std()
df['Is_Anomaly'] = df['Distance'] > threshold

# Print the anomalies
print("Detected Anomalies:")
print(df[df['Is_Anomaly']][['Log No.', 'Date', 'Admin', 'User', 'Action', 'Status', 'Location']])

# Print summary statistics
print("\nSummary:")
print(f"Total logs: {len(df)}")
print(f"Anomalies detected: {df['Is_Anomaly'].sum()}")
print(f"Anomaly percentage: {df['Is_Anomaly'].mean() * 100:.2f}%")

# Additional plots
plt.figure(figsize=(12, 10))

# 1. Distribution of clusters
plt.subplot(3, 2, 1)
sns.countplot(x='Cluster', data=df)
plt.title('Cluster Distribution')
plt.savefig(os.path.join(plot_dir, 'cluster_distribution.png'))
plt.close()

# 2. Time Distribution by Hour
plt.subplot(3, 2, 2)
sns.histplot(df['Hour'], bins=24, kde=True)
plt.title('Distribution of Actions by Hour')
plt.savefig(os.path.join(plot_dir, 'distribution_by_hour.png'))
plt.close()

# 3. Action Distribution
plt.subplot(3, 2, 3)
sns.countplot(y='Action', data=df)
plt.title('Action Distribution')
plt.savefig(os.path.join(plot_dir, 'action_distribution.png'))
plt.close()

# 4. Status Distribution
plt.subplot(3, 2, 4)
sns.countplot(y='Status', data=df)
plt.title('Status Distribution')
plt.savefig(os.path.join(plot_dir, 'status_distribution.png'))
plt.close()

# 5. Distance Distribution
plt.subplot(3, 2, 5)
sns.histplot(df['Distance'], bins=30, kde=True)
plt.title('Distance from Cluster Center')
plt.savefig(os.path.join(plot_dir, 'distance_distribution.png'))
plt.close()

# 6. Anomalies vs. Non-anomalies
plt.subplot(3, 2, 6)
sns.histplot(data=df, x='Hour', hue='Is_Anomaly', multiple='stack', bins=24)
plt.title('Anomalies vs Non-anomalies by Hour')
plt.savefig(os.path.join(plot_dir, 'anomalies_vs_non_anomalies.png'))
plt.close()

print("Audit Logs Verified.")