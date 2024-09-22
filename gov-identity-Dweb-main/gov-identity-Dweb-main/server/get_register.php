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
    
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (user_first_name, user_surname, user_sex, user_dob, user_country, user_email, user_phone, user_password, user_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $firstName, $surname, $sex, $dob, $country, $email, $cellNumber, $password, $status);

    if ($stmt->execute()) {
      $stmt->close();
      $conn->close();
      header("location: login.php?success=Registered Successfully. Login to proceed.");
    } else {
      header("location: register.php?error=Failed to register user. Try again or Contact Support Team.");
    }
}