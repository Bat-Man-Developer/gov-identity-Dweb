<?php
session_start();

class ImageProcessor {
    private $upload_dir;

    public function __construct($upload_dir) {
        $this->upload_dir = rtrim($upload_dir, '/') . '/';
        $this->ensureDirectoryExists();
    }

    private function ensureDirectoryExists() {
        if (!file_exists($this->upload_dir)) {
            if (!mkdir($this->upload_dir, 0777, true)) {
                // Handle directory creation failure
            }
        }
    }

    public function processAndSaveImage($img_data) {
        $img = $this->cleanImageData($img_data);
        $data = base64_decode($img);

        if ($data === false) {
            return ['success' => false, 'message' => 'Failed to decode image data.'];
        }

        $file = $this->upload_dir . "login_user_image.png";
        
        if (file_put_contents($file, $data) !== false) {
            return ['success' => true, 'file' => $file];
        } else {
            return ['success' => false, 'message' => 'Failed to process image data.'];
        }
    }

    private function cleanImageData($img) {
        $img = str_replace('data:image/png;base64,', '', $img);
        return str_replace(' ', '+', $img);
    }
}

class Model {
    private $pythonExePath = "c:/Users/user/AppData/Local/Programs/Python/Python312/python.exe";
    private $scriptPath = "c:/Xampp/htdocs/gov-identity-Dweb/python/login_facial_recognition.py";

    public function getModel() {
        return $this->executeCommand();
    }

    private function executeCommand() {
        $escapedPythonScript = escapeshellarg($this->scriptPath);
        $fullCommand = $this->pythonExePath . " " . $escapedPythonScript;
        return shell_exec($fullCommand);
    }
}

class UserAuthentication {
    public function authenticate($message) {
        $lastTwoChars = substr($message, -2);

        if ($lastTwoChars == "18") {
            return $this->processUserData($message);
        } else {
            return ['success' => false, 'message' => 'Facial Recognition failed. No matching user found.'];
        }
    }

    private function processUserData($message) {
        $user_data = explode('_', $message);

        if (count($user_data) == 5) {
            $this->setSessionData($user_data);
        } else {
            return ['success' => false, 'message' => 'Invalid user data format.'];
        }
    }

    private function setSessionData($user_data) {
        $_SESSION['userID'] = $user_data[0];
        $_SESSION['userFirstName'] = $user_data[1];
        $_SESSION['userLastName'] = $user_data[2];
        $_SESSION['userEmail'] = $user_data[3];
    }
}

// Usage
$upload_dir = '../datasets/temp_users_image/';
$imageProcessor = new ImageProcessor($upload_dir);
$result = $imageProcessor->processAndSaveImage($_POST['face_data']);

if ($result['success']) {
    $model = new Model();
    $message = trim($model->getModel());

    $userAuth = new UserAuthentication();
    $userAuth->authenticate($message);

} else {
    echo json_encode($result);
}