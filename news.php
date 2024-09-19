<?php 
include("includes/header.php");
?>
<body>
    <header>
        <h1>Home Affairs News</h1>
        <img src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
        <?php if(isset($_SESSION['email'])){ ?>
            <form id="logout-form" method="POST" action="about.php">
                <a><button type="submit" id="logoutBtn" name="logoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    <main>
        <div class="news-articles">
            <div class="news-article">
                <h2>New Passport Application Process Launched</h2>
                <p>As of October 2024, the Department of Home Affairs has introduced a new online passport application process aimed at reducing waiting times and improving service delivery.</p>
                <p><strong>Date:</strong> October 1, 2024</p>
            </div>
            <div class="news-article">
                <h2>Public Services Week Announced</h2>
                <p>The Department will celebrate Public Services Week from November 10-15, 2024, highlighting the importance of public services and engagement with citizens.</p>
                <p><strong>Date:</strong> September 15, 2024</p>
            </div>
            <div class="news-article">
                <h2>Launch of Digital ID System</h2>
                <p>A new digital identification system will be rolled out nationwide starting January 2025. This initiative aims to modernize identity verification processes.</p>
                <p><strong>Date:</strong> August 22, 2024</p>
            </div>
        </div>
        <div class="sidebar">
            <h3>Important Announcements</h3>
            <ul>
                <li>Office closures on public holidays.</li>
                <li>Extended hours for passport services during peak season.</li>
                <li>New contact numbers for all provincial offices.</li>
            </ul>
        </div>
    </main>
</body>
<?php 
include("includes/footer.php");
?>
