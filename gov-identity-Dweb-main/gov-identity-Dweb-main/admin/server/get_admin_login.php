<?php
include("admin_connection.php");

if (isset($_POST['adminLoginBtn'])) {
    $email = $_POST['adminEmail'];
    $password = $_POST['adminPassword'];

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT admin_first_name, admin_surname, admin_password FROM admins WHERE admin_email = ?");
    $stmt->bind_param("s", $email);
    if($stmt->execute()){
        $stmt->bind_result($firstName,$surname,$hashedPassword);
        $stmt->store_result();
    }
    else{
        header("location: admin_login.php?error=Something went wrong. Try again or Contact Support.");
    }
    
    if ($stmt->num_rows == 1) {
        $stmt->fetch();
        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, set session variable
            $_SESSION['adminFirstName'] = $firstName;
            $_SESSION['adminSurname'] = $surname;
            $_SESSION['adminEmail'] = $email;
            $stmt->close();
            $conn->close();
            header("Location: admin_dashboard.php?success=Admin Logged in successfully"); // Redirect to the dashboard
            exit();
        } else {
            $stmt->close();
            $conn->close();
            header("Location: admin_login.php?error=Invalid password");
        }
    } else {
        $stmt->close();
        $conn->close();
        header("Location: admin_login.php?error=Invalid email");
    }
}