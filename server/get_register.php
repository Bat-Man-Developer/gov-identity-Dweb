<?php
include("connection.php"); // Include database connection file

if (isset($_POST['registerBtn'])) {
    $firstName = $_POST['firstName'];
    $surname = $_POST['surname'];
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
    $stmt = $conn->prepare("INSERT INTO users (user_first_name, user_surname, user_sex, user_dob, user_country, user_email, user_phone, user_password, user_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $firstName, $surname, $sex, $dob, $country, $email, $cellNumber, $password, $status);

    if ($stmt->execute()) {
      $userID = $stmt->insert_id;
      $stmt->close();
      
      $log_action = "user register";
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

      header("location: ../login.php?success=Registered Successfully. Login to proceed.");
    } else {
      header("location: ../register.php?error=Failed to register user. Try again or Contact Support Team.");
    }
} else {
  $log_action = "user register";
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