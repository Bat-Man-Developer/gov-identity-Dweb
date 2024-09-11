<?php 
include("includes/header.php");
?>
<body>
    <header>
        <h1>Home Affairs: Login</h1>
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
        <form id="login-form">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter Email" required>

            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Enter Password" required>

            <button onclick="login()">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p>Are you an employee? <a href="admin/login.php" target="_blank">Staff sign in</a></p>
    </main>
</body>
<?php 
include("includes/footer.php");
?>