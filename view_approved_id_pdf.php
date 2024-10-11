<?php
session_start();
require('fpdf/fpdf.php');
include("server/connection.php");

if(!isset($_SESSION['userID']) || !isset($_GET['userIDNumber'])){
    header("Location: login.php?error=Unauthorised Access.");
    exit();
}

$userID = $_SESSION['userID'];
$idNumber = $_GET['userIDNumber'];

// Fetch user and application details
$stmt = $conn->prepare("SELECT u.user_first_name, u.user_last_name, u.user_sex, u.user_dob, u.user_country, u.user_email, u.user_phone, 
                        a.id_application_photo_path, a.id_application_place_of_birth, a.id_application_address, a.id_application_father_name, 
                        a.id_application_mother_name, a.id_application_marital_status, a.id_application_occupation, a.id_application_document_type 
                        FROM users u 
                        JOIN id_applications a ON u.user_id = a.user_id 
                        WHERE u.user_id = ? AND a.id_application_id_number = ? AND a.id_application_status = 'Approved'");
$stmt->bind_param("is", $userID, $idNumber);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    
    // Generate PDF
    $pdf = generatePDF($row['user_first_name'], $row['user_last_name'], $row['user_sex'], $row['user_dob'], $row['user_country'], 
                       $row['user_email'], $row['user_phone'], $idNumber, $row['id_application_place_of_birth'], $row['id_application_address'], 
                       $row['id_application_father_name'], $row['id_application_mother_name'], $row['id_application_marital_status'], 
                       $row['id_application_occupation'], $row['id_application_document_type'], $row['id_application_photo_path']);
    
    // Output PDF
    $pdf->Output('I', 'approved_id.pdf');
} else {
    header("Location: dashboard.php?error=No approved application found.");
    exit();
}

function generatePDF($firstName, $lastName, $sex, $dob, $country, $email, $phone, $idNumber, $placeOfBirth, $address, $fatherName, $motherName, $maritalStatus, $occupation, $documentType, $applicationPhotoPath) {
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Add header
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Identity Document', 0, 1, 'C');
    
    // Add photo
    if (file_exists($applicationPhotoPath)) {
        $pdf->Image($applicationPhotoPath, 10, 30, 30);
    }
    
    // Add personal information
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetXY(50, 30);
    $pdf->Cell(0, 10, "Name: $firstName $lastName", 0, 1);
    $pdf->SetX(50);
    $pdf->Cell(0, 10, "Gender: $sex", 0, 1);
    $pdf->SetX(50);
    $pdf->Cell(0, 10, "Date of Birth: $dob", 0, 1);
    $pdf->SetX(50);
    $pdf->Cell(0, 10, "ID Number: $idNumber", 0, 1);
    
    // Add more details
    $pdf->Ln(10);
    $pdf->Cell(0, 10, "Place of Birth: $placeOfBirth", 0, 1);
    $pdf->Cell(0, 10, "Address: $address", 0, 1);
    $pdf->Cell(0, 10, "Father's Name: $fatherName", 0, 1);
    $pdf->Cell(0, 10, "Mother's Name: $motherName", 0, 1);
    $pdf->Cell(0, 10, "Marital Status: $maritalStatus", 0, 1);
    $pdf->Cell(0, 10, "Occupation: $occupation", 0, 1);
    $pdf->Cell(0, 10, "Document Type: $documentType", 0, 1);
    
    return $pdf;
}