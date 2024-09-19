<?php 
include("includes/header.php");
?>
<body>
    <header>
        <h1>Home Affairs: About Us</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="team.php">Team</a>
        <?php if(isset($_SESSION['email'])){ ?>
            <form id="logout-form" method="POST" action="about.php">
                <a><button type="submit" id="logoutBtn" name="logoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    <main>
        <h2>Welcome to Our About Page</h2>
        <p>At the Department of Home Affairs, our mission is to provide efficient and effective services to all citizens. We strive to ensure that every individual has access to the resources they need to navigate the complexities of civil documentation and citizenship.</p>
        
        <h2>Our Vision</h2>
        <p>We envision a society where all individuals are empowered through knowledge and access to vital services, fostering a sense of belonging and identity.</p>
        
        <h2>Our Values</h2>
        <ul style="list-style-type: none; padding: 0;">
            <li>Integrity: We uphold the highest standards of honesty and transparency.</li>
            <li>Respect: We treat everyone with dignity and respect.</li>
            <li>Service: We are committed to serving our community with excellence.</li>
            <li>Innovation: We embrace change and adapt to the evolving needs of our society.</li>
        </ul>

        <h2>Contact Information</h2>
        <p>If you have any questions or need assistance, please feel free to reach out to us.</p>
        <button class="contact-button" onclick="window.location.href='contact.html'">Contact Us</button>
        
        <img src="department of home affairs.jpeg" alt="Department of Home Affairs" class="department-image"> <!-- Additional Image -->
    </main>
</body>
<?php 
include("includes/footer.php");
?>