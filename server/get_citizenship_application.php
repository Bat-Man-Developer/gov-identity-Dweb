<?php
include("connection.php"); // Include database connection file

if (isset($_POST['submitCitizenship'])) {
    $userID = $_POST['userID'];
    $fullName = $_POST['fullName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $placeOfBirth = $_POST['placeOfBirth'];
    $currentNationality = $_POST['currentNationality'];
    $residenceYears = $_POST['residenceYears'];
    $languageProficiency = $_POST['languageProficiency'];
    $criminalRecord = $_POST['criminalRecord'];
    $employmentStatus = $_POST['employmentStatus'];
    $reasonForApplication = $_POST['reasonForApplication'];
    $applicationStatus = "Pending";
    
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO citizenship_applications (citizenship_application_full_name, citizenship_application_date_of_birth, citizenship_application_place_of_birth, citizenship_application_current_nationality, citizenship_application_residence_years, citizenship_application_language_proficiency, citizenship_application_criminal_record, citizenship_application_employment_status, citizenship_application_reason_for_application, citizenship_application_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisisss", $fullName, $dateOfBirth, $placeOfBirth, $currentNationality, $residenceYears, $languageProficiency, $criminalRecord, $employmentStatus, $reasonForApplication, $applicationStatus);

    if ($stmt->execute()) {
        $stmt->close();

        $log_action = "citizenship application";
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

        header("location: ../citizenship_application.php?success=Application submitted successfully. We will review your application and contact you soon.");
    } else {
        header("location: ../citizenship_application.php?error=Failed to submit application. Please try again or contact support.");
    }
}else {
    $log_action = "user citizenship application";
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