<?php
include("connection.php"); // Include database connection file

if (isset($_POST['submitIDApplication'])) {
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
    $applicationStatus = "pending";
    
    // Handle file upload for photo
    $photo = $_FILES['photo']['name'];
    $photoTemp = $_FILES['photo']['tmp_name'];
    $photoPath = "uploads/" . uniqid() . "_" . $photo;
    move_uploaded_file($photoTemp, $photoPath);

    // Handle file upload for signature
    $signature = $_FILES['signature']['name'];
    $signatureTemp = $_FILES['signature']['tmp_name'];
    $signaturePath = "uploads/" . uniqid() . "_" . $signature;
    move_uploaded_file($signatureTemp, $signaturePath);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO id_applications (full_name, date_of_birth, place_of_birth, gender, nationality, address, father_name, mother_name, marital_status, occupation, document_type, photo_path, signature_path, application_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $fullName, $dateOfBirth, $placeOfBirth, $gender, $nationality, $address, $fatherName, $motherName, $maritalStatus, $occupation, $documentType, $photoPath, $signaturePath, $applicationStatus);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("location: id_application.php?success=ID application submitted successfully. We will process your application and contact you soon.");
    } else {
        header("location: id_application.php?error=Failed to submit ID application. Please try again or contact support.");
    }
}