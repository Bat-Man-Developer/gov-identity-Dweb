<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image']) && isset($_POST['userID'])) {
    $userID = $_POST['userID'];
    $upload_dir = '../uploads/user_' . $userID . '/user_photo' . "/"; // Ensure the directory path ends with a slash

    // Check if the directory exists and is writable
    if (!file_exists($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            header("Location: ../id_application.php?errorMessage=Failed to create directory.");
            exit;
        }
    }

    $img = $_POST['image'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);

    $file = $upload_dir . "ID_photo_" . $userID . '.png';

    // Check if the data was decoded properly
    if ($data === false) {
        header("Location: ../id_application.php?errorMessage=Failed to decode image data.");
        exit;
    }

    if (file_put_contents($file, $data) !== false) {
        header("Location: ../id_application.php?successMessage=ID application submitted successfully. We will process your application and contact you soon.");
        exit;
    } else {
        header("Location: ../id_application.php?errorMessage=Failed to register and save the photo.");
        exit;
    }
} else {
    header("Location: ../id_application.php?errorMessage=Invalid request.");
    exit;
}