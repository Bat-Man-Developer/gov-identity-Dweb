<?php
$log_action = "admin view verify audit logs";
$log_status = "success";
$log_location = $_SERVER['REMOTE_ADDR'];
$log_date = date('Y-m-d H:i:s');

// Prepare SQL statement for audit log
$stmt1 = $conn->prepare("INSERT INTO audit_logs (admin_id, log_action, log_status, log_location, log_date)
VALUES (?, ?, ?, ?, ?)");
$stmt1->bind_param("sssss", $adminID, $log_action, $log_status, $log_location, $log_date);

if ($stmt1->execute()) {
    $stmt1->close();
}