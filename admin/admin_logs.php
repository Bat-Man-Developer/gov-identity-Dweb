<?php
include("includes/admin_header.php");
//if user is not logged in then take user to login page
if(!isset($_SESSION['adminEmail'])){
  header('location: admin_login.php?error=Unauthorised Access. Please Login.');
  exit;
}
?>
<body>
    <div class="container">
        <header>
            <h1>Home Affairs Admin: Logs</h1>
            <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo" width="200">
        </header>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_review_applications.php">Review Applications</a>
            <a href="admin_view_users.php">View Users</a>
            <?php if(isset($_SESSION['adminEmail'])){ ?>
                <form id="admin-logout-form" method="POST" action="admin_logs.php">
                    <a><button type="submit" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
                </form>
            <?php } ?>
        </nav>
        <section class="logs-section">
            <h2>Activity Logs</h2>
            <p>View and review user activity for compliance and security.</p>

            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-09-04</td>
                        <td>john.doe</td>
                        <td>Login</td>
                        <td>Success</td>
                    </tr>
                    <tr>
                        <td>2024-09-03</td>
                        <td>jane.smith</td>
                        <td>Password Change</td>
                        <td>Success</td>
                    </tr>
                    <!-- Add more log entries as needed -->
                </tbody>
            </table>
        </section>
    </div>
</body>
<?php
include("includes/admin_footer.php");
?>
