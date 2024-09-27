<?php
include("includes/admin_header.php");
//if admin is not logged in then take admin to login page
if(!isset($_SESSION['adminID'])){
    $log_action = "admin view verify audit logs";
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

    header("Location: ../index.php?error=Unauthorised Access. Trespassers will be prosecuted. Activity has been logged."); // Redirect to index
    exit();
}
else{
    $adminID = $_SESSION['adminID'];
    $log_action = "admin view audit logs";
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

// Function to call Python script for anomaly detection
function detectAnomalies($logs) {
    $pythonScript = 'python3 python/audit_logs_anomaly_detection.py';
    $input = json_encode($logs);
    $descriptorSpec = array(
        0 => array("pipe", "r"),  // stdin
        1 => array("pipe", "w"),  // stdout
        2 => array("pipe", "w")   // stderr
    );
    $process = proc_open($pythonScript, $descriptorSpec, $pipes);
    
    if (is_resource($process)) {
        fwrite($pipes[0], $input);
        fclose($pipes[0]);
        
        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        
        $errors = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        
        proc_close($process);
        
        if ($errors) {
            error_log("Python Error: " . $errors);
            return false;
        }
        
        return json_decode($output, true);
    }
    return false;
}

// Fetch logs
include('server/get_admin_audit_logs.php');

// Detect anomalies
$anomalies = detectAnomalies($logs);
?>

<body>
    <div class="container">
        <header>
            <h1>Home Affairs Admin: Verify Audit Logs</h1>
            <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
        </header>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_review_citizenship_applications.php">Review Citizenship Applications</a>
            <a href="admin_review_visa_applications.php">Review Visa Applications</a>
            <a href="admin_review_civil_registrations.php">Review Civil Registrations</a>
            <a href="admin_review_id_applications.php">Review ID Applications</a>
            <a href="admin_view_users.php">View Users</a>
            <?php if(isset($_SESSION['adminEmail'])){ ?>
                <form id="admin-logout-form" method="POST" action="admin_verify_audit_logs.php">
                    <a><button type="submit" class="logoutBtn" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
                </form>
            <?php } ?>
        </nav>
        <main>
            <h2>Verify Audit Logs</h2>
            <p>Review audit logs and detect possible anomalies using machine learning.</p>

            <h3>Possible Anomalies</h3>
            <?php if ($anomalies): ?>
                <table class="anomalies-table">
                    <thead>
                        <tr>
                            <th>Log ID</th>
                            <th>Date</th>
                            <th>Admin</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Anomaly Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($anomalies as $anomaly): ?>
                            <tr class="anomaly-row">
                                <td><?php echo $anomaly['log_id']; ?></td>
                                <td><?php echo $anomaly['log_date']; ?></td>
                                <td><?php echo $anomaly['admin_id']; ?></td>
                                <td><?php echo $anomaly['user_id']; ?></td>
                                <td><?php echo $anomaly['log_action']; ?></td>
                                <td><?php echo $anomaly['log_status']; ?></td>
                                <td><?php echo $anomaly['log_location']; ?></td>
                                <td><?php echo $anomaly['anomaly_type']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No anomalies detected.</p>
            <?php endif; ?>

            <h3>All Audit Logs</h3>
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
                    <?php foreach($logs as $log): ?>
                    <tr>
                        <td><?php echo $log['log_id']; ?></td>
                        <td><?php echo $log['log_date']; ?></td>
                        <td><?php echo $log['log_admin_id']; ?></td>
                        <td><?php echo $log['log_user_id']; ?></td>
                        <td><?php echo $log['log_action']; ?></td>
                        <td><?php echo $log['log_status']; ?></td>
                        <td><?php echo $log['log_location']; ?></td>
                    </tr>
                    <?php endforeach; ?>
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