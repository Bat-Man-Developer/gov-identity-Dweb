<?php
include("connection.php"); // Include database connection file

if (isset($_POST['registerBtn'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $country = $_POST['country'];
    $dob = $_POST['dob'];
    $sex = $_POST['sex'];
    $cellNumber = $_POST['cellNumber'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $status = "active";
    
    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT user_email FROM users WHERE user_email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) {
        $checkEmail->close();
        header("location: ../register.php?error=Email already exists. Please use a different email.");
        exit();
    }
    $checkEmail->close();
    
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (user_first_name, user_last_name, user_sex, user_dob, user_country, user_email, user_phone, user_password, user_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $firstName, $surname, $sex, $dob, $country, $email, $cellNumber, $password, $status);

    if ($stmt->execute()) {
      $userID = $stmt->insert_id;
      $stmt->close();
      
      $log_action = "user register";
      $log_status = "success";

      // Get the IP address
      $log_ip_address = $_SERVER['REMOTE_ADDR'];

      // Get the location
      $log_location = getLocationFromIP($log_ip_address);

      $log_date = date('Y-m-d H:i:s');

      // Prepare SQL statement for audit log
      $stmt1 = $conn->prepare("INSERT INTO audit_logs (user_id, log_action, log_status, log_location, log_date)
      VALUES (?, ?, ?, ?, ?)");
      $stmt1->bind_param("sssss", $userID, $log_action, $log_status, $log_location, $log_date);

      if ($stmt1->execute()) {
        $stmt1->close();
      }

      header("location: ../login.php?success=Registered Successfully. Login to proceed.");
    } else {
      header("location: ../register.php?error=Failed to register user. Try again or Contact Support Team.");
    }
} else {
  $log_action = "user register";
  $log_status = "failed";

  // Get the IP address
  $log_ip_address = $_SERVER['REMOTE_ADDR'];

  // Get the location
  $log_location = getLocationFromIP($log_ip_address);

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

// Function to get location from IP address
function isPrivateIP($ip) {
  $private_ranges = [
      '10.0.0.0' => '10.255.255.255',
      '172.16.0.0' => '172.31.255.255',
      '192.168.0.0' => '192.168.255.255',
  ];

  foreach ($private_ranges as $start => $end) {
      if (ip2long($ip) >= ip2long($start) && ip2long($ip) <= ip2long($end)) {
          return true;
      }
  }
  return false;
}

function getLocationFromIP($ip) {
  if (isPrivateIP($ip)) {
      return "Private IP Address";
  }

  $url = "http://ip-api.com/json/{$ip}";
  $response = file_get_contents($url);
  $data = json_decode($response, true);

  if ($data['status'] == 'success') {
      return "{$data['city']}, {$data['regionName']}, {$data['country']}";
  } else {
      return "Unknown";
  }
}