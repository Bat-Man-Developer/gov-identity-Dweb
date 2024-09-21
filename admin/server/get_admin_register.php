<?php
include("admin_connection.php");

if (isset($_POST['adminRegisterBtn'])) {
    $firstName = $_POST['adminFirstName'];
    $surname = $_POST['adminSurname'];
    $email = $_POST['adminEmail'];
    $password = password_hash($_POST['adminPassword'], PASSWORD_DEFAULT); // Hash the password

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO admins (admin_first_name, admin_surname, admin_email, admin_password)
    VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $surname, $email, $password);

    if ($stmt->execute()) {
      $stmt->close();
      $conn->close();
      header("location: admin_login.php?success=Admin Registered Successfully. Login to proceed.");
    } else {
      header("location: admin_register.php?error=Failed to register admin. Try again or Contact Support Team.");
    }
}