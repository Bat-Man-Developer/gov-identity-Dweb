<?php
include("includes/admin_header.php");
//if user is not logged in then take user to login page
if(!isset($_SESSION['adminEmail'])){
  header('location: admin_login.php?error=Unauthorised Access. Please Login.');
  exit;
}
?>
<body>
    <header>
        <h1>Home Affairs Admin: Review Applications</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_view_users.php">View Users</a>
        <a href="admin_logs.php">Logs</a>
        <?php if(isset($_SESSION['adminEmail'])){ ?>
            <form id="admin-logout-form" method="POST" action="admin_review_applications.php">
                <a><button type="submit" class="logoutBtn" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <h2>Application List</h2>
        <table>
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>User Name</th>
                    <th>Application Type</th>
                    <th>Submission Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>101</td>
                    <td>John Doe</td>
                    <td>Passport</td>
                    <td>2023-08-01</td>
                    <td>Pending</td>
                    <td>
                        <a href="approve_application.html?id=101" class="action-button">Approve</a>
                        <a href="deny_application.html?id=101" class="action-button">Deny</a>
                    </td>
                </tr>
                <tr>
                    <td>102</td>
                    <td>Jane Smith</td>
                    <td>ID Card</td>
                    <td>2023-08-05</td>
                    <td>Under Review</td>
                    <td>
                        <a href="approve_application.html?id=102" class="action-button">Approve</a>
                        <a href="deny_application.html?id=102" class="action-button">Deny</a>
                    </td>
                </tr>
                <tr>
                    <td>103</td>
                    <td>Miriam Anozie</td>
                    <td>Birth Certificate</td>
                    <td>2023-08-10</td>
                    <td>Approved</td>
                    <td>
                        <a href="view_application.html?id=103" class="action-button">View</a>
                    </td>
                </tr>
                <tr>
                    <td>104</td>
                    <td>Kay Gundo</td>
                    <td>Marriage Certificate</td>
                    <td>2023-08-15</td>
                    <td>Denied</td>
                    <td>
                        <a href="view_application.html?id=104" class="action-button">View</a>
                    </td>
                </tr>
                <!-- Add more application rows as needed -->
            </tbody>
        </table>
    </main>
</body>
<?php
include("includes/admin_footer.php");
?>
