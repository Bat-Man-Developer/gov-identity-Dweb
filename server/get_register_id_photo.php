<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image']) && isset($_POST['userID'])) {
    $userID = $_POST['userID'];
    $upload_dir = '../uploads/user_' . $userID . '/user_photo' . "/"; // Ensure the directory path ends with a slash

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

    $file = $upload_dir . "ID_photo_" . $userID . '.png';

    // Check if the data was decoded properly
    if ($data === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to decode image data.']);
    }

    if (file_put_contents($file, $data) !== false) {
        echo json_encode(['success' => true, 'message' => 'Photo saved successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save the photo.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}