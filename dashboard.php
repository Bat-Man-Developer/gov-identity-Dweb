<?php 
include("includes/header.php");
?>
<body>
    <header>
        <h1>Home Affairs: Dashboard</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
        <a><button onclick="logout()">Logout</button></a>
    </nav>
    
    <main>
        <h2>Welcome, [User Name]</h2>
        <p>Select a service to proceed:</p>
        <button class="service-button">Citizenship Application</button>
        <button class="service-button">Visa Application</button>
        <button class="service-button">Civil Registration</button>
        <button class="service-button">Identity Document Application</button>

        <div class="applications-section">
            <h3>Your Applications</h3>
            <p>No applications submitted yet.</p>
        </div>

        <button class="service-button" onclick="window.location.href='logout.html'">Logout</button>
    </main>
</body>
<?php 
include("includes/footer.php");
?>
