<?php
include('connection.php');
//Logout Home Affairs
if(isset($_POST['logoutBtn'])){
  unset($_SESSION['firstName']);
  unset($_SESSION['surname']);
  unset($_SESSION['email']);
  header('location: ../login.php');
  exit;
}