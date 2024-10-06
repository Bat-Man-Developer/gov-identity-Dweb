<?php
$log_action = "admin view server verify audit logs";
$log_status = "success";

// Get the IP address
$log_ip_address = $_SERVER['REMOTE_ADDR'];

// Get the location
$log_location = getLocationFromIP($log_ip_address);

$log_date = date('Y-m-d H:i:s');

// Prepare SQL statement for audit log
$stmt1 = $conn->prepare("INSERT INTO audit_logs (admin_id, log_action, log_status, log_location, log_date)
VALUES (?, ?, ?, ?, ?)");
$stmt1->bind_param("sssss", $adminID, $log_action, $log_status, $log_location, $log_date);

if ($stmt1->execute()) {
    $stmt1->close();
}

// Save audit logs to CSV
function saveAuditLogsToCSV($conn, $filename = 'datasets/audit_logs.csv') {
    $query = "SELECT * FROM audit_logs";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $file = fopen($filename, 'w');

        // Write headers
        $headers = array('log_id', 'admin_id', 'user_id', 'log_action', 'log_status', 'log_location', 'log_date');
        fputcsv($file, $headers);

        // Write data
        while ($row = $result->fetch_assoc()) {
            fputcsv($file, $row);
        }

        fclose($file);
        return true;
    } else {
        return false;
    }
}

// Call the function to save audit logs to CSV
if (saveAuditLogsToCSV($conn)) {

} else {
    echo "No audit logs found or error saving to CSV.";
}