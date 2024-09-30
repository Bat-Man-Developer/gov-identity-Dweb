class Model {
    constructor() {
        this.message = null;
    }

    initializePlots() {
        const plots = [
            { id: 'elbow-method', filename: 'model_plots/elbow_method.png' },
            { id: 'cluster-distribution', filename: 'model_plots/cluster_distribution.png' },
            { id: 'time-distribution', filename: 'model_plots/distribution_by_hour.png' },
            { id: 'action-distribution', filename: 'model_plots/action_distribution.png' },
            { id: 'status-distribution', filename: 'model_plots/status_distribution.png' },
            { id: 'distance-distribution', filename: 'model_plots/distance_distribution.png' },
            { id: 'anomalies-vs-non-anomalies', filename: 'model_plots/anomalies_vs_non_anomalies.png' },
        ];
    
        plots.forEach(plot => {
            const img = document.getElementById(plot.id);
            if (img) {
                img.src = plot.filename;
                img.onerror = function() {
                    this.src = 'model_plots/placeholder.png';
                    this.alt = 'No Image Found';
                };
            }
        });
    }

    getModel() {
        $.ajax({
            url: 'call_python/get_admin_verify_audit_logs.php',
            method: 'GET',
            success: (response) => {
                const values = response.split(','); // Assuming ',' is the delimiter
                
                this.message = values[0];
                $('#responseMessage').html(this.message);

                this.initializePlots();
            },
            error: (xhr, status, error) => {
                console.error('Error getting Model Results:', error);
            }
        });
    }
}

$(document).ready(function() {
    const model = new Model();
    model.getModel();
});