<?php 
include("includes/admin_header.php");
include("server/get_admin_login.php");
?>
<body>
    <header>
        <h1>Home Affairs Admin: Staff Login</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
    </header>
    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_review_applications.php">Review Applications</a>
        <a href="admin_view_users.php">View Users</a>
        <a href="admin_logs.php">Logs</a>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <form id="reg-form" method="POST" action="admin_login.php">
            <label for="email"> Staff Email</label>
            <input type="email" id="adminEmail" name="adminEmail" placeholder="Enter Email" required>

            <label for="password">Staff Password</label>
            <input type="password" id="adminPassword" name="adminPassword" placeholder="Enter Password" required>

            <button type="submit" name="adminLoginBtn">Staff Login</button>
        </form>
        <p>Don't have an Admin account? <a href="admin_register.php">Register here</a></p>
    </main>
</body>
<?php 
include("includes/admin_footer.php");
?>