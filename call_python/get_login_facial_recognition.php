<?php

// Ensure the directory path ends with a slash
$upload_dir = '../datasets/temp_users_image/'; 

// Check if the directory exists and is writable
if (!file_exists($upload_dir)) {
    if (!mkdir($upload_dir, 0777, true)) {
        echo json_encode(['success' => false, 'message' => 'Failed to create directory.']);
    }
}

$img = $_POST['face_data'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);

// Name the photo path
$file = $upload_dir . "login_user_image.png";
$photoPath = $file;

// Check if the data was decoded properly
if ($data === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to decode image data.']);
}

if (file_put_contents($file, $data) !== false) {

} else {
    echo json_encode(['success' => false, 'message' => 'Failed to process image data.']);
}
class Model
{
    private $pythonExePath = "c:/Users/user/AppData/Local/Programs/Python/Python312/python.exe";
    private $scriptPath = "c:/Xampp/htdocs/gov-identity-Dweb/python/login_facial_recognition.py";

    private function executeCommand()
    {
        $escapedPythonScript = escapeshellarg($this->scriptPath);
        $fullCommand = $this->pythonExePath . " " . $escapedPythonScript;
        return shell_exec($fullCommand);
    }

    public function getModel()
    {
        return $this->executeCommand();
    }
}

$model = new Model();
$message = trim($model->getModel());

include("../server/connection.php");

$lastTwoChars = substr($message, -2);
echo $lastTwoChars;

if ($lastTwoChars == "18") {
    // Assuming the user's data is stored in the format 'userID_userFirstName_userLastName_userEmail'
    $user_data = explode('_', $message);
    if (count($user_data) == 4) {
        $_SESSION['userID'] = $user_data[0];
        $_SESSION['userFirstName'] = $user_data[1];
        $_SESSION['userLastName'] = $user_data[2];
        $_SESSION['userEmail'] = $user_data[3];
        echo json_encode(['success' => true, 'message' => 'Image match successful!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid user data format.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Facial Recognition failed. No matching user found.']);
}