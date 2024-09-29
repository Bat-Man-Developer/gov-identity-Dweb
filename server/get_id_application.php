<?php
include("connection.php"); // Include database connection file

if (isset($_POST['submitIDApplication'])) {
    $userID = $_POST['userID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $placeOfBirth = $_POST['placeOfBirth'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $address = $_POST['address'];
    $fatherName = $_POST['fatherName'];
    $motherName = $_POST['motherName'];
    $maritalStatus = $_POST['maritalStatus'];
    $occupation = $_POST['occupation'];
    $documentType = $_POST['documentType'];
    $applicationStatus = "Pending";
    
    // Define user directory paths
    $userDir = "../uploads/user_" . $userID;
    $signatureDir = $userDir . "/user_signature";

    // Check if signature directory exists, if not create it
    if (!is_dir($signatureDir)) {
        mkdir($signatureDir, 0755, true);
    }

    // Handle file upload for signature
    $signature = $_FILES['signature']['name'];
    $signatureTemp = $_FILES['signature']['tmp_name'];
    $signaturePath = $signatureDir . "/" . $signature;
    move_uploaded_file($signatureTemp, $signaturePath);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO id_applications (user_id, id_application_first_name, id_application_last_name, id_application_date_of_birth, id_application_place_of_birth, id_application_gender, id_application_nationality, id_application_address, id_application_father_name, id_application_mother_name, id_application_marital_status, id_application_occupation, id_application_document_type, id_application_signature_path, id_application_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssssssssss", $userID, $firstName, $lastName, $dateOfBirth, $placeOfBirth, $gender, $nationality, $address, $fatherName, $motherName, $maritalStatus, $occupation, $documentType, $signaturePath, $applicationStatus);

    if ($stmt->execute()) {
        $stmt->close();

        $log_action = "id application";
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

        header("location: ../register_id_photo.php?success=Take a professional photo behind a white background and save it.&userID=" . $userID);
    } else {
        header("location: ../id_application.php?error=Failed to submit ID application. Please try again or contact support.");
    }
}else {
    $log_action = "user id application";
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