<?php
include("includes/admin_header.php");
// Set session
if(!isset($_SESSION['adminLoggedIn'])){
    $_SESSION['adminLoggedIn'] = true;
}
//if admin is not logged in then take admin to login page
if(!isset($_GET['adminID']) || $_SESSION['adminLoggedIn'] == "false"){
    $log_action = "admin view dashboard";
    $log_status = "failed";
    $log_location = $_SERVER['REMOTE_ADDR'];
    $log_date = date('Y-m-d H:i:s');

    // Prepare SQL statement for audit log
    $stmt1 = $conn->prepare("INSERT INTO audit_logs (log_action, log_status, log_location, log_date)
    VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("ssss", $log_action, $log_status, $log_location, $log_date);

    if ($stmt1->execute()) {
        $stmt1->close();
    }

    // Set session
    $_SESSION['adminLoggedIn'] = false;
    header("Location: admin_login.php?error=Unauthorised Access. Trespassers will be prosecuted. Activity has been logged."); // Redirect to index
    exit();
}
else{
    $_SESSION['adminID'] = $adminID = $_GET['adminID'];
    $_SESSION['adminEmail'] =  $_GET['adminEmail'];
    
    $log_action = "admin view dashboard";
    $log_status = "success";
    $log_location = $_SERVER['REMOTE_ADDR'];
    $log_date = date('Y-m-d H:i:s');

    // Prepare SQL statement for audit log
    $stmt1 = $conn->prepare("INSERT INTO audit_logs (admin_id, log_action, log_status, log_location, log_date)
    VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("sssss", $adminID, $log_action, $log_status, $log_location, $log_date);

    if ($stmt1->execute()) {
        $stmt1->close();
    }
}
include("server/get_admin_dashboard.php");
?>
<body>
    <header>
        <h1>Home Affairs Admin: Dashboard</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="admin_review_citizenship_applications.php">Review Citizenship Applications</a>
        <a href="admin_review_visa_applications.php">Review Visa Applications</a>
        <a href="admin_review_civil_registrations.php">Review Civil Registrations</a>
        <a href="admin_review_id_applications.php">Review ID Applications</a>
        <a href="admin_view_users.php">View Users</a>
        <a href="admin_audit_logs.php">Audit Logs</a>
        <?php if(isset($_SESSION['adminEmail'])){ ?>
            <form id="admin-logout-form" method="POST" action="admin_dashboard.php">
                <a><button type="submit" class="logoutBtn" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    <main id="admin-pages">
        <div id="admin-div">
            <!------------- Website Messages----------->
            <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
            <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
            <h2>Welcome, <span id="admin-info"></span></h2><br>
            <h3 id="adminEmail">Email: <?php echo $_SESSION['adminEmail']; ?></h3><br><br>
            <div class="section">
                <h2>Audit Logs Management</h2>
                <a href="admin_audit_logs.php" class="link-button">View Audit Logs</a>
                <a href="admin_verify_audit_logs.php" class="link-button">Verify Audit Logs</a>
            </div>
            <div class="section">
                <h2>User Management</h2>
                <a href="admin_view_users.php" class="link-button">View Users</a>
            </div>
            <div class="section">
                <h2>Application Management</h2>
                <a href="admin_review_citizenship_applications.php" class="link-button">Review Citizenship Applications</a>
                <a href="admin_review_visa_applications.php" class="link-button">Review Visa Applications</a>
                <a href="admin_review_civil_registrations.php" class="link-button">Review Civil Registrations</a>
                <a href="admin_review_id_applications.php" class="link-button">Review ID Applications</a>
            </div>
            <div class="section">
                <h2 style="font-weight: bold; color: #007A33;">Analytics Dashboard</h2>
                
                <div class="metric">
                    <h3>Total Applications</h3>
                    <p style="font-size: 24px; font-weight: bold; color: #007A33;"><?php echo $totalApplications; ?></p>
                </div>
                <div class="metric">
                    <h3>Approved Applications</h3>
                    <p style="font-size: 24px; font-weight: bold; color: #007A33;"><?php echo $totalApprovedApplications; ?></p>
                </div>
                <div class="metric">
                    <h3>Denied Applications</h3>
                    <p style="font-size: 24px; font-weight: bold; color: #007A33;"><?php echo $totalDeniedApplications; ?></p>
                </div>
                <div class="metric">
                    <h3>Pending Applications</h3>
                    <p style="font-size: 24px; font-weight: bold; color: #007A33;"><?php echo $totalPendingApplications; ?></p>
                </div>
                
                <div class="chart-container" style="margin-top: 30px;">
                    <canvas id="applicationChart" style="max-height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </main>
</body>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('applicationChart').getContext('2d');
    const applicationChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total', 'Approved', 'Denied', 'Pending'],
            datasets: [{
                label: 'Applications',
                data: [<?php echo $totalApplications; ?>, <?php echo $totalApprovedApplications; ?>, <?php echo $totalDeniedApplications; ?>, <?php echo $totalPendingApplications; ?>],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.7)',  // Total
                    'rgba(75, 192, 192, 0.7)',   // Approved
                    'rgba(255, 99, 132, 0.7)',    // Denied
                    'rgba(54, 162, 235, 0.7)'     // Pending
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)', 
                    'rgba(75, 192, 192, 1)', 
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Applications',
                        font: {
                            size: 16
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Application Status',
                        font: {
                            size: 16
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            }
        }
    });
</script>
<script src="js/admin_dashboard.js"></script>
<?php
include("includes/admin_footer.php");
?>