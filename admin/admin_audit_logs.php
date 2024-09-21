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
            <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
        </header>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_review_id_applications.php">Review ID Applications</a>
            <a href="admin_view_users.php">View Users</a>
            <?php if(isset($_SESSION['adminEmail'])){ ?>
                <form id="admin-logout-form" method="POST" action="admin_audit_logs.php">
                    <a><button type="submit" class="logoutBtn" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
                </form>
            <?php } ?>
        </nav>
        <main>
            <h2>Activity Logs</h2>
            <p>View and review user activity for compliance and security.</p>

            <table>
                <thead>
                    <tr>
                        <th>Log No.</th>
                        <th>Date</th>
                        <th>Admin</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include('server/get_admin_audit_logs.php');
                        foreach($logs as $log){?>
                    <tr>
                        <td><?php echo $log['log_id']; ?></td>
                        <td><?php echo $log['log_date']; ?></td>
                        <td><?php echo $log['log_admin_id']; ?></td>
                        <td><?php echo $log['log_user_id']; ?></td>
                        <td><?php echo $log['log_action']; ?></td>
                        <td><?php echo $log['log_status']; ?></td>
                        <td><?php echo $log['log_location']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="page-btn">
                <span class="page-item <?php if($pagenumber <= 1){ echo 'disabled';} ?>"><a class="page-link" href="<?php if($pagenumber <= 1){ echo '#';}else{ echo "?pagenumber=".($pagenumber - 1);} ?>">Prev</a></span>

                <span class="page-item"><a class="page-link" href="?pagenumber=1">1</a></span>
                <span class="page-item"><a class="page-link" href="?pagenumber=2">2</a></span>

                <?php if($pagenumber >= 3) { ?>
                    <span class="page-item"><a class="page-link" href="#">...</a></span>
                    <span class="page-item"><a class="page-link" href="<?php echo "?pagenumber=".$pagenumber; ?>"><?php echo $pagenumber; ?></a></span>
                <?php } ?>

                <span class="page-item <?php if($pagenumber >= $totalnumberofpages){ echo 'disabled';} ?>"><a class="page-link" href="<?php if($pagenumber >= $totalnumberofpages){ echo '#';}else{ echo "?pagenumber=".($pagenumber + 1);} ?>">Next</a></span>
            </div>
        </main>
    </div>
</body>
<?php
include("includes/admin_footer.php");
?>
