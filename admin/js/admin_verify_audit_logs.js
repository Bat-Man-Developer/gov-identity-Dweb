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
                const rows = response.split('\n').filter(row => row.trim() !== '');
                const container = $('#responseContainer');
                
                container.empty(); // Clear the loading message
                
                rows.forEach((row, index) => {
                    const values = row.split('|');
                    if (values.length > 0) {
                        const message = values.slice(0, -1).join('|'); // Join all values except the last empty one
                        container.append(`<p class="response-message" id="responseMessage${index}">${message}</p>`);
                    }
                });
    
                if (rows.length === 0) {
                    container.append('<p class="response-message">No results found.</p>');
                }
    
                this.initializePlots();
            },
            error: (xhr, status, error) => {
                console.error('Error getting Model Results:', error);
                $('#responseContainer').html('<p class="response-message">Error loading results. Please try again later.</p>');
            }
        });
    }
}

$(document).ready(function() {
    const model = new Model();
    model.getModel();
});