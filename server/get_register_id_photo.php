<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image'])) {
    $upload_dir = 'uploads/'; // Make sure this directory exists and is writable
    
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $img = $_POST['image'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    
    $file = $upload_dir . uniqid() . '.png';
    
    if (file_put_contents($file, $data)) {
        echo 'Photo saved successfully!';
    } else {
        echo 'Failed to save the photo.';
    }
} else {
    echo 'Invalid request.';
}