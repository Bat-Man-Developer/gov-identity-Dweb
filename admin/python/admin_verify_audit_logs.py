import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
import os
from sklearn.cluster import KMeans
from sklearn.preprocessing import StandardScaler
from sklearn.impute import SimpleImputer

class Model:
    def __init__(self, data_path):
        self.df = pd.read_csv(data_path)  # Load data from CSV
        self.X = None
        self.X_scaled = None
        self.kmeans = None
        self.plot_dir = 'c:/Xampp/htdocs/gov-identity-Dweb/admin/model_plots'
        os.makedirs(self.plot_dir, exist_ok=True)

    def load_data(self):
        self.df['log_date'] = pd.to_datetime(self.df['log_date'])
        self.df['Hour'] = self.df['log_date'].dt.hour
        self.df['Minute'] = self.df['log_date'].dt.minute
        self.df['Second'] = self.df['log_date'].dt.second
        self.df['Action_encoded'] = pd.factorize(self.df['log_action'])[0]
        self.df['Status_encoded'] = pd.factorize(self.df['log_status'])[0]

    def prepare_features(self):
        features = ['Hour', 'Minute', 'Second', 'admin_id', 'user_id', 'Action_encoded', 'Status_encoded']
        self.X = self.df[features].copy()
        imputer = SimpleImputer(strategy='mean')
        self.X = pd.DataFrame(imputer.fit_transform(self.X), columns=self.X.columns)
        scaler = StandardScaler()
        self.X_scaled = scaler.fit_transform(self.X)

    def elbow_method(self):
        inertia = []
        k_range = range(1, 11)
        for k in k_range:
            kmeans = KMeans(n_clusters=k, random_state=42)
            kmeans.fit(self.X_scaled)
            inertia.append(kmeans.inertia_)

        plt.figure(figsize=(10, 6))
        plt.plot(k_range, inertia, marker='o')
        plt.title('Elbow Method For Optimal k')
        plt.xlabel('Number of clusters')
        plt.ylabel('Inertia')
        plt.xticks(k_range)
        plt.grid()
        plt.savefig(os.path.join(self.plot_dir, 'elbow_method.png'))
        plt.close()

    def perform_clustering(self, n_clusters=3):
        self.kmeans = KMeans(n_clusters=n_clusters, random_state=42)
        self.df['Cluster'] = self.kmeans.fit_predict(self.X_scaled)
        self.df['Distance'] = np.min(self.kmeans.transform(self.X_scaled), axis=1)
        threshold = self.df['Distance'].mean() + 2 * self.df['Distance'].std()
        self.df['Is_Anomaly'] = self.df['Distance'] > threshold

    def plot_distributions(self):
        plots = [
            ('Cluster Distribution', 'cluster_distribution.png', lambda: sns.countplot(x='Cluster', data=self.df)),
            ('Distribution of Actions by Hour', 'distribution_by_hour.png', lambda: sns.histplot(self.df['Hour'], bins=24, kde=True)),
            ('Action Distribution', 'action_distribution.png', lambda: sns.countplot(y='log_action', data=self.df)),
            ('Status Distribution', 'status_distribution.png', lambda: sns.countplot(y='log_status', data=self.df)),
            ('Distance from Cluster Center', 'distance_distribution.png', lambda: sns.histplot(self.df['Distance'], bins=30, kde=True)),
            ('Anomalies vs Non-anomalies by Hour', 'anomalies_vs_non_anomalies.png', lambda: sns.histplot(data=self.df, x='Hour', hue='Is_Anomaly', multiple='stack', bins=24))
        ]

        for title, filename, plot_func in plots:
            plt.figure(figsize=(12, 6))
            plot_func()
            plt.title(title)
            plt.savefig(os.path.join(self.plot_dir, filename))
            plt.close()

    def print_anomalies(self):
        print("Detected Anomalies:|")  # Original print statement
        print("No., Log, Admin, User, Status, Date, Location|")
        print(self.df[self.df['Is_Anomaly']][['log_id', 'admin_id', 'user_id', 'log_action', 'log_status', 'log_date',]].assign(log_location=self.df[self.df['Is_Anomaly']]['log_location'] + '|'))

    def print_summary(self):
        print("Summary:|")  # Original print statement
        print(f"Total logs: {len(self.df)}|")  # Original print statement
        print(f"Anomalies detected: {self.df['Is_Anomaly'].sum()}|")  # Original print statement
        print(f"Anomaly percentage: {self.df['Is_Anomaly'].mean() * 100:.2f}%|")  # Original print statement

    def run(self):
        self.load_data()
        self.prepare_features()
        self.elbow_method()
        self.perform_clustering()
        self.plot_distributions()
        self.print_anomalies()
        self.print_summary()
        print("Audit Logs Verified.")

# Usage
data_path = 'C:/Xampp/htdocs/gov-identity-Dweb/admin/datasets/audit_logs.csv'
model = Model(data_path)
model.run()