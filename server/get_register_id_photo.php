<?php
include("connection.php"); // Include database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image']) && isset($_POST['userID'])) {
    $userID = $_POST['userID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dob'];
    $placeOfBirth = $_POST['pob'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $address = $_POST['address'];
    $fatherName = $_POST['fatherName'];
    $motherName = $_POST['motherName'];
    $maritalStatus = $_POST['maritalStatus'];
    $occupation = $_POST['occupation'];
    $documentType = $_POST['documentType'];
    $applicationStatus = $_POST['applicationStatus'];
    $signaturePath = $_POST['signaturePath'];

    // Ensure the directory path ends with a slash
    $upload_dir = '../uploads/user_' . $userID . '/user_photo' . "/"; 

    // Check if the directory exists and is writable
    if (!file_exists($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            echo json_encode(['success' => false, 'message' => 'Failed to create directory.']);
        }
    }

    $img = $_POST['image'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);

    // Name the photo path
    $file = $upload_dir . "ID_photo_" . $userID . '.png';
    $photoPath = $file;

    // Check if the data was decoded properly
    if ($data === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to decode image data.']);
    }

    if (file_put_contents($file, $data) !== false) {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO id_applications (user_id, id_application_first_name, id_application_last_name, id_application_date_of_birth, id_application_place_of_birth, id_application_gender, id_application_nationality, id_application_address, id_application_father_name, id_application_mother_name, id_application_marital_status, id_application_occupation, id_application_document_type, id_application_photo_path, id_application_signature_path, id_application_status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssssssssssss", $userID, $firstName, $lastName, $dateOfBirth, $placeOfBirth, $gender, $nationality, $address, $fatherName, $motherName, $maritalStatus, $occupation, $documentType, $photoPath, $signaturePath, $applicationStatus);

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
            echo json_encode(['success' => true, 'message' => 'Photo saved successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to register and save the photo. Try again or contact support team.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save the photo.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
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