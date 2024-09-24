<?php 
include("includes/admin_header.php");
include("server/get_admin_login.php");
?>
<body>
    <header>
        <h1>Home Affairs Admin: Staff Login</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="admin_dashboard.php">   </a>
    </nav>
    <main  id="reg-login-form">
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <p class="text-center" id="message"></p>
        <form id="login-form">
            <label for="email"> Staff Email</label>
            <input type="email" id="adminEmail" placeholder="Enter Email" required>

            <label for="password">Staff Password</label>
            <input type="password" id="adminPassword" placeholder="Enter Password" required>

            <button type="submit" class="loginBtn">Staff Login</button>
        </form>
        <p>Don't have an Admin account? <a href="admin_register.php">Register here</a></p>
    </main>
</body>
<script src="js/admin_login.js"></script>
<?php 
include("includes/admin_footer.php");
?>