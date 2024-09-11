<?php 
include("includes/header.php");
?>
<body>
    <header>
        <h1>Home Affairs Admin: Staff Login</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="review_applications.php">Review Applications</a>
        <a href="view_users.php">View Users</a>
        <a href="logs.php">Logs</a>
    </nav>
    <main>
        <form id="login-form">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter Email" required>

            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Enter Password" required>

            <button type="submit">Login</button>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>