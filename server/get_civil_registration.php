<?php
include("connection.php"); // Include database connection file

if (isset($_POST['submitRegistration'])) {
    $registrationType = $_POST['registrationType'];
    $fullName = $_POST['fullName'];
    $dateOfEvent = $_POST['dateOfEvent'];
    $placeOfEvent = $_POST['placeOfEvent'];
    $fatherName = $_POST['fatherName'];
    $motherName = $_POST['motherName'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contactNumber'];
    $registrationStatus = "pending";
    
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO civil_registrations (registration_type, full_name, date_of_event, place_of_event, father_name, mother_name, gender, nationality, address, contact_number, registration_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $registrationType, $fullName, $dateOfEvent, $placeOfEvent, $fatherName, $motherName, $gender, $nationality, $address, $contactNumber, $registrationStatus);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("location: civil_registration.php?success=Registration submitted successfully. We will process your registration and contact you soon.");
    } else {
        header("location: civil_registration.php?error=Failed to submit registration. Please try again or contact support.");
    }
}