<?php
include("includes/header.php");
//if user is not logged in then take user to login page
if(!isset($_SESSION['email'])){
  header('location: login.php?error=Register or Login.');
  exit;
}
?>
<body>
    <header>
        <h1>Home Affairs: Dashboard</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
        <a href="login.php"><button type="submit"  name="loginBtn">Login</button></a>
        <a href="register.php"><button type="submit" id="registerBtn" name="registerBtn">Register</button></a>
    </nav>
    
    <main>
    </main>
</body>
<?php 
include("includes/footer.php");
?>