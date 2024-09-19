<?php
session_start();
if(isset($_POST['adminLogoutBtn'])){
    unset($_SESSION['adminFirstName']);
    unset($_SESSION['adminSurname']);
    unset($_SESSION['adminEmail']);
    header('location: admin_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_style.css">
    <script src="https://cdn.ethers.io/lib/ethers-5.0.umd.min.js"></script>
    <title>Home Affairs</title>
</head>