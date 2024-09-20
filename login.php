<?php 
include("includes/header.php");
include("server/get_login.php");
?>
<body>
    <header>
        <h1>Home Affairs: Login</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
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
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <form id="reg-form" method="POST" action="login.php">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter Email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>

            <button type="submit" name="loginBtn">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p>Are you an employee? <a href="admin/admin_login.php" target="_blank">Staff Sign in</a></p>
    </main>
</body>
<?php 
include("includes/footer.php");
?>