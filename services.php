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
        <a href="news.php">News</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
        <a href="login.php"><button type="submit"  name="loginBtn">Login</button></a>
        <a href="register.php"><button type="submit" id="registerBtn" name="registerBtn">Register</button></a>
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
                <p>Apply for ID and passport to confirm your identity.</p>
            </div><br>
        </div>
    </main>
</body>
<?php 
include("includes/footer.php");
?>

