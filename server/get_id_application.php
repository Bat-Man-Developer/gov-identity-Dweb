<?php
include("connection.php"); // Include database connection file

if (isset($_POST['submitIDApplication'])) {
    $userID = $_POST['userID'];
    $fullName = $_POST['fullName'];
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
    $photoDir = $userDir . "/user_photo";
    $signatureDir = $userDir . "/user_signature";

    // Check if photo directory exists, if not create it
    if (!is_dir($photoDir)) {
        mkdir($photoDir, 0755, true);
    }

    // Check if signature directory exists, if not create it
    if (!is_dir($signatureDir)) {
        mkdir($signatureDir, 0755, true);
    }

    // Handle file upload for photo
    $photo = $_FILES['photo']['name'];
    $photoTemp = $_FILES['photo']['tmp_name'];
    $photoPath = $photoDir . "/" . $photo;
    move_uploaded_file($photoTemp, $photoPath);

    // Handle file upload for signature
    $signature = $_FILES['signature']['name'];
    $signatureTemp = $_FILES['signature']['tmp_name'];
    $signaturePath = $signatureDir . "/" . $signature;
    move_uploaded_file($signatureTemp, $signaturePath);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO id_applications (id_application_full_name, id_application_date_of_birth, id_application_place_of_birth, id_application_gender, id_application_nationality, id_application_address, id_application_father_name, id_application_mother_name, id_application_marital_status, id_application_occupation, id_application_document_type, id_application_photo_path, id_application_signature_path, id_application_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $fullName, $dateOfBirth, $placeOfBirth, $gender, $nationality, $address, $fatherName, $motherName, $maritalStatus, $occupation, $documentType, $photoPath, $signaturePath, $applicationStatus);

    if ($stmt->execute()) {
        $stmt->close();

        $log_action = "id application";
        $log_status = "success";
        $log_location = $_SERVER['REMOTE_ADDR'];
        $log_date = date('Y-m-d H:i:s');

        // Prepare SQL statement for audit log
        $stmt1 = $conn->prepare("INSERT INTO audit_logs (user_id, log_action, log_status, log_location, log_date)
        VALUES (?, ?, ?, ?, ?)");
        $stmt1->bind_param("sssss", $userID, $log_action, $log_status, $log_location, $log_date);

        if ($stmt1->execute()) {
            $stmt1->close();
        }

        header("location: ../id_application.php?success=ID application submitted successfully. We will process your application and contact you soon.");
    } else {
        header("location: ../id_application.php?error=Failed to submit ID application. Please try again or contact support.");
    }
}else {
    $log_action = "user id application";
    $log_status = "failed";
    $log_location = $_SERVER['REMOTE_ADDR'];
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