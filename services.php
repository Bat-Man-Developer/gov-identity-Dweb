<?php 
include("includes/header.php");
?>
<body>
    <header>
        <h1>Home Affairs: Services</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="news.php">News</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
        <?php if(isset($_SESSION['email'])){ ?>
            <form id="logout-form" method="POST" action="services.php">
                <a><button type="submit" id="logoutBtn" name="logoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    <main>
        <h2>Services Offered</h2>
        <div class="service-list">
            <div class="service-item">
                <h3>Citizenship Applications</h3>
                <p>Apply for South African citizenship. Ensure you meet all the eligibility criteria.</p>
            </div>
            <div class="service-item">
                <h3>Visa Applications</h3>
                <p>Apply for various types of visas based on your travel needs.</p>
            </div>
            <div class="service-item">
                <h3>Civil Registration</h3>
                <p>Register births, marriages, and deaths to maintain accurate records.</p>
            </div>
            <div class="service-item">
                <h3>Identity Document Applications</h3>
                <p>Apply for IDs and passports to confirm your identity.</p>
            </div><br>
            <a style="display: flex; justify-content: center;" href="login.php"><button type="submit" id="loginBtn" name="loginBtn">Login</button></a>
        </div>
    </main>
</body>
<?php 
include("includes/footer.php");
?>

