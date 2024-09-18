<?php
include('admin_connection.php');
//Logout Home Affairs
if(isset($_POST['adminLogoutBtn'])){
  unset($_SESSION['adminFirstName']);
  unset($_SESSION['adminSurname']);
  unset($_SESSION['adminEmail']);
  header('location: ../admin_login.php');
  exit;
}