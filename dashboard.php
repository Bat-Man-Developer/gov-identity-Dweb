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
        <?php if(isset($_SESSION['email'])){ ?>
            <form id="logout-form" method="POST" action="dashboard.php">
                <a><button type="submit" id="logoutBtn" name="logoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <h2>Welcome, <?php echo $_SESSION['firstName']. " " . $_SESSION['surname'];?></h2>
        <p>Select a service to proceed:</p>
        <button class="service-button">Citizenship Application</button>
        <button class="service-button">Visa Application</button>
        <button class="service-button">Civil Registration</button>
        <button class="service-button">Identity Document Application</button>

        <div class="applications-section">
            <h3>Your Applications</h3>
            <p>No applications submitted yet.</p>
        </div>

        <form id="logout-form" method="POST" action="server/get_logout.php">
            <a><button type="submit" id="logoutBtn" name="logoutBtn">Logout</button></a>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>
