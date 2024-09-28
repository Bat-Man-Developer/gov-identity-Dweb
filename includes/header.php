<?php
// Ensure secure session handling
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (!session_id()) {
    session_start();
}

// Regenerate session ID periodically for security
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 300) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// Logout Btn Clicked
if (isset($_POST['logoutBtn'])) {
    // Define an array of session variables to unset
    $sessionVars = [
        'userID',
        'userEmail',
        'userFirstName',
        'userSurname',
        'userLoggedIn'
    ];

    $count = 0;
    // Unset each session variable
    foreach ($sessionVars as $var) {
        if (isset($_SESSION[$var])) {
            unset($_SESSION[$var]);
        }
    }

    $_SESSION['userLoggedIn'] = "false";

    // Destroy the session
    session_destroy();

    header("Location: logout.php");
    exit;
}
include("server/connection.php"); // Include database connection file
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.ethers.io/lib/ethers-5.0.umd.min.js"></script>
    <title>Home Affairs</title>
</head>
