<?php
include("connection.php"); // Include database connection file

if (isset($_POST['submitVisa'])) {
    $fullName = $_POST['fullName'];
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
    $stmt = $conn->prepare("INSERT INTO visa_applications (visa_application_full_name, visa_application_passport_number, visa_application_nationality, visa_application_date_of_birth, visa_application_type, visa_application_entry_date, visa_application_stay_duration, visa_application_purpose, visa_application_accommodation, visa_application_financial_means_proof, visa_application_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssissss", $fullName, $passportNumber, $nationality, $dateOfBirth, $visaType, $entryDate, $stayDuration, $purpose, $accommodation, $financialMeansPath, $applicationStatus);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("location: visa_application.php?success=Visa application submitted successfully. We will process your application and contact you soon.");
    } else {
        header("location: visa_application.php?error=Failed to submit visa application. Please try again or contact support.");
    }
}