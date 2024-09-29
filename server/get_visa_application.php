<?php
include("connection.php"); // Include database connection file

if (isset($_POST['submitVisa'])) {
    $userID = $_POST['userID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $passportNumber = $_POST['passportNumber'];
    $nationality = $_POST['nationality'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $visaType = $_POST['visaType'];
    $entryDate = $_POST['entryDate'];
    $stayDuration = $_POST['stayDuration'];
    $purpose = $_POST['purpose'];
    $accommodation = $_POST['accommodation'];
    $applicationStatus = "Pending";
    
    // Handle file upload for financial means proof
    $financialMeans = $_FILES['financialMeans']['name'];
    $financialMeansTemp = $_FILES['financialMeans']['tmp_name'];
    $financialMeansPath = "uploads/" . uniqid() . "_" . $financialMeans;
    move_uploaded_file($financialMeansTemp, $financialMeansPath);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO visa_applications (user_id, visa_application_first_name, visa_application_last_name, visa_application_passport_number, visa_application_nationality, visa_application_date_of_birth, visa_application_type, visa_application_entry_date, visa_application_stay_duration, visa_application_purpose, visa_application_accommodation, visa_application_financial_means_proof, visa_application_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssisssss", $userID, $firstName, $lastName, $passportNumber, $nationality, $dateOfBirth, $visaType, $entryDate, $stayDuration, $purpose, $accommodation, $financialMeansPath, $applicationStatus);

    if ($stmt->execute()) {
        $stmt->close();

        $log_action = "visa application";
        $log_status = "success";

        // Get the IP address
        $log_ip_address = $_SERVER['REMOTE_ADDR'];

        // Get the location
        $log_location = getLocationFromIP($log_ip_address);

        $log_date = date('Y-m-d H:i:s');

        // Prepare SQL statement for audit log
        $stmt1 = $conn->prepare("INSERT INTO audit_logs (user_id, log_action, log_status, log_location, log_date)
        VALUES (?, ?, ?, ?, ?)");
        $stmt1->bind_param("sssss", $userID, $log_action, $log_status, $log_location, $log_date);

        if ($stmt1->execute()) {
            $stmt1->close();
        }

        header("location: ../visa_application.php?success=Visa application submitted successfully. We will process your application and contact you soon.");
    } else {
        header("location: ../visa_application.php?error=Failed to submit visa application. Please try again or contact support.");
    }
}else {
    $log_action = "user visa application";
    $log_status = "failed";

    // Get the IP address
    $log_ip_address = $_SERVER['REMOTE_ADDR'];

    // Get the location
    $log_location = getLocationFromIP($log_ip_address);

    $log_date = date('Y-m-d H:i:s');

    // Prepare SQL statement for audit log
    $stmt1 = $conn->prepare("INSERT INTO audit_logs (log_action, log_status, log_location, log_date)
    VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("ssss", $log_action, $log_status, $log_location, $log_date);

    if ($stmt1->execute()) {
        $stmt1->close();
    }

    header("Location: ../index.php?error=Unauthorised Access. Trespassers will be prosecuted. Activity has been logged."); // Redirect to index
    exit();
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