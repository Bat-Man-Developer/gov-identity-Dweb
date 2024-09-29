<?php
include("admin_connection.php");

// Function to count Approved, Denied, and Pending applications
function countApplicationStatus($conn, $table, $statusColumn) {
    $stmt = $conn->prepare("SELECT $statusColumn, COUNT(*) AS count FROM $table GROUP BY $statusColumn");
    $stmt->execute();
    $result = $stmt->get_result();
    $approved = 0;
    $denied = 0;
    $pending = 0;
    while ($row = $result->fetch_assoc()) {
        $status = strtolower($row[$statusColumn]);
        if ($status == 'Approved') {
            $approved = $row['count'];
        } elseif ($status == 'Denied') {
            $denied = $row['count'];
        } elseif ($status == 'Pending') {
            $pending = $row['count'];
        }
    }
    $stmt->close();
    return [$approved, $denied, $pending];
}

// 1. Citizenship applications
$stmt = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM citizenship_applications");
$stmt->execute();
$stmt->bind_result($totalrecords);
$stmt->store_result();
$stmt->fetch();
$stmt->close();
$totalCitizenshipApplications = $totalrecords;
list($totalApprovedCitizenshipApplications, $totalDeniedCitizenshipApplications, $totalPendingCitizenshipApplications) = countApplicationStatus($conn, 'citizenship_applications', 'citizenship_application_status');

// 2. Visa applications
$stmt1 = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM visa_applications");
$stmt1->execute();
$stmt1->bind_result($totalrecords1);
$stmt1->store_result();
$stmt1->fetch();
$stmt1->close();
$totalVisaApplications = $totalrecords1;
list($totalApprovedVisaApplications, $totalDeniedVisaApplications, $totalPendingVisaApplications) = countApplicationStatus($conn, 'visa_applications', 'visa_application_status');

// 3. Civil registrations
$stmt2 = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM civil_registrations");
$stmt2->execute();
$stmt2->bind_result($totalrecords2);
$stmt2->store_result();
$stmt2->fetch();
$stmt2->close();
$totalCivilRegistrations = $totalrecords2;
list($totalApprovedCivilRegistrations, $totalDeniedCivilRegistrations, $totalPendingCivilRegistrations) = countApplicationStatus($conn, 'civil_registrations', 'civil_registration_status');

// 4. ID applications
$stmt3 = $conn->prepare("SELECT COUNT(*) AS fldtotalrecords FROM id_applications");
$stmt3->execute();
$stmt3->bind_result($totalrecords3);
$stmt3->store_result();
$stmt3->fetch();
$stmt3->close();
$totalIDApplications = $totalrecords3;
list($totalApprovedIDApplications, $totalDeniedIDApplications, $totalPendingIDApplications) = countApplicationStatus($conn, 'id_applications', 'id_application_status');

// 5. Total applications
$totalApplications = $totalCitizenshipApplications + $totalVisaApplications + $totalCivilRegistrations + $totalIDApplications;

// 6. Total approved applications
$totalApprovedApplications = $totalApprovedCitizenshipApplications + $totalApprovedVisaApplications + $totalApprovedCivilRegistrations + $totalApprovedIDApplications;

// 7. Total denied applications
$totalDeniedApplications = $totalDeniedCitizenshipApplications + $totalDeniedVisaApplications + $totalDeniedCivilRegistrations + $totalDeniedIDApplications;

// 8. Total pending applications
$totalPendingApplications = $totalPendingCitizenshipApplications + $totalPendingVisaApplications + $totalPendingCivilRegistrations + $totalPendingIDApplications;

$log_action = "admin view server dashboard";
$log_status = "success";

// Get the IP address
$log_ip_address = $_SERVER['REMOTE_ADDR'];

// Get the location
$log_location = getLocationFromIP($log_ip_address);

$log_date = date('Y-m-d H:i:s');

// Prepare SQL statement for audit log
$stmt4 = $conn->prepare("INSERT INTO audit_logs (admin_id, log_action, log_status, log_location, log_date)
VALUES (?, ?, ?, ?, ?)");
$stmt4->bind_param("sssss", $adminID, $log_action, $log_status, $log_location, $log_date);

if ($stmt4->execute()) {
    $stmt4->close();
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