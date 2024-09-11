<?php 
include("includes/header.php");
?>
<body>
    <button class="theme-toggle" onclick="toggleTheme()">🌓</button>
    <div class="app-container">
        <h1>User Management dApp</h1>
        <div id="landingPage">
            <h2>Welcome to our dApp!</h2>
            <p>Please register or login to continue.</p>
        </div>
        <div class="container">
            <div class="form-container">
                <h2>Register</h2>
                <input type="text" id="registerUsername" placeholder="Username" required>
                <input type="password" id="registerPassword" placeholder="Password" required>
                <button onclick="register()">Register</button>
            </div>
            <div class="form-container">
                <h2>Login</h2>
                <input type="password" id="loginPassword" placeholder="Password" required>
                <button onclick="login()">Login</button>
            </div>
        </div>
        <div id="userInfo" style="display: none;">
            <h2>Welcome, <span id="username"></span>!</h2>
            <p>You are now logged in.</p>
            <button onclick="logout()">Logout</button>
        </div>
    </div>
</body>
<?php 
include("includes/footer.php");
?>