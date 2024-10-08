<?php
include("connection.php"); // Include database connection file

// Set the directory where the local face images are stored
$local_face_dir = '../datasets/stored_user_images/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $faceData = $_POST['face_data'];

    // Check if the face data matches a face in the local directory
    $matched_user = null;
    foreach (scandir($local_face_dir) as $filename) {
        if ($filename !== '.' && $filename !== '..') {
            $local_face_data = file_get_contents($local_face_dir . $filename);
            if ($local_face_data === $faceData) {
                $matched_user = pathinfo($filename, PATHINFO_FILENAME);
                break;
            }
        }
    }

    if ($matched_user) {
        // Assuming the user's data is stored in the format 'userID_firstName_lastName'
        $user_data = explode('_', $matched_user);
        $_SESSION['userID'] = $user_data[0];
        $_SESSION['userFirstName'] = $user_data[1];
        $_SESSION['userLastName'] = $user_data[2];
        $_SESSION['userEmail'] = $user_data[3];
        header('location: ../dashboard.php?userID=' . $_SESSION['userID'] . "&userFirstName=" . $_SESSION['userFirstName'] . "&userLastName=" . $_SESSION['userLastName']  . "&userEmail=" . $_SESSION['userEmail']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Facial Recognition failed. No matching user found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}