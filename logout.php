<?php 
include("includes/header.php");
?>
<body>
    <header>
        <h1>Home Affairs: Logout</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
    </nav>
    <main>
        <h2>You have been logged out</h2>
        <p>Thank you for using our services.</p>
        <button onclick="window.location.href='login.php'">Return to Login</button>
    </main>
</body>
<?php 
include("includes/footer.php");
?>
