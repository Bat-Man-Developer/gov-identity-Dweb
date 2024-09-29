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

// Function to get location from IP address
function isPrivateIP($ip) {
    $private_ranges = [
        '10.0.0.0' => '10.255.255.255',
        '172.16.0.0' => '172.31.255.255',
        '192.168.0.0' => '192.168.255.255',
    ];

    foreach ($private_ranges as $start => $end) {
        if (ip2long($ip) >= ip2long($start) && ip2long($ip) <= ip2long($end)) {
            return true;
        }
    }
    return false;
}

function getLocationFromIP($ip) {
    if (isPrivateIP($ip)) {
        return "Private IP Address";
    }

    $url = "http://ip-api.com/json/{$ip}";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data['status'] == 'success') {
        return "{$data['city']}, {$data['regionName']}, {$data['country']}";
    } else {
        return "Unknown";
    }
}