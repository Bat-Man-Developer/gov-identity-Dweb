<?php
session_start();
include("server/connection.php"); // Include database connection file

if(isset($_POST['logoutBtn'])){
    unset($_SESSION['userID']);
    unset($_SESSION['firstName']);
    unset($_SESSION['surname']);
    unset($_SESSION['email']);
    header('location: login.php');
    exit;
}
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
