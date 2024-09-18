<?php
include("connection.php"); // Include database connection file

if (isset($_POST['loginBtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT user_first_name, user_surname, user_password FROM users WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    if($stmt->execute()){
        $stmt->bind_result($firstName,$surname,$hashedPassword);
        $stmt->store_result();
    }
    else{
        header("location: login.php?error=Something went wrong. Try again or Contact Support.");
    }
    
    if ($stmt->num_rows == 1) {
        $stmt->fetch();
        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, set session variable
            $_SESSION['firstName'] = $firstName;
            $_SESSION['surname'] = $surname;
            $_SESSION['email'] = $email;
            $stmt->close();
            $conn->close();
            header("Location: dashboard.php?success=Logged in successfully"); // Redirect to the dashboard
            exit();
        } else {
            $stmt->close();
            $conn->close();
            header("Location: login.php?error=Invalid password");
        }
    } else {
        $stmt->close();
        $conn->close();
        header("Location: login.php?error=Invalid email");
    }
}