<?php
include("connection.php"); // Include database connection file

if (isset($_POST['submitCitizenship'])) {
    $fullName = $_POST['fullName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $placeOfBirth = $_POST['placeOfBirth'];
    $currentNationality = $_POST['currentNationality'];
    $residenceYears = $_POST['residenceYears'];
    $languageProficiency = $_POST['languageProficiency'];
    $criminalRecord = $_POST['criminalRecord'];
    $employmentStatus = $_POST['employmentStatus'];
    $reasonForApplication = $_POST['reasonForApplication'];
    $applicationStatus = "pending";
    
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO citizenship_applications (full_name, date_of_birth, place_of_birth, current_nationality, residence_years, language_proficiency, criminal_record, employment_status, reason_for_application, application_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisisss", $fullName, $dateOfBirth, $placeOfBirth, $currentNationality, $residenceYears, $languageProficiency, $criminalRecord, $employmentStatus, $reasonForApplication, $applicationStatus);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("location: citizenship_application.php?success=Application submitted successfully. We will review your application and contact you soon.");
    } else {
        header("location: citizenship_application.php?error=Failed to submit application. Please try again or contact support.");
    }
}