<?php
include("includes/admin_header.php");
//if admin is not logged in then take admin to login page
if(!isset($_SESSION['adminID'])){
    $log_action = "admin view audit logs";
    $log_status = "failed";

    // Get the IP address
    $log_ip_address = $_SERVER['REMOTE_ADDR'];

    // Get the location
    $log_location = getLocationFromIP($log_ip_address);
    
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

    // Get the IP address
    $log_ip_address = $_SERVER['REMOTE_ADDR'];

    // Get the location
    $log_location = getLocationFromIP($log_ip_address);

    $log_date = date('Y-m-d H:i:s');

    // Prepare SQL statement for audit log
    $stmt1 = $conn->prepare("INSERT INTO audit_logs (admin_id, log_action, log_status, log_location, log_date)
    VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("sssss", $adminID, $log_action, $log_status, $log_location, $log_date);

    if ($stmt1->execute()) {
        $stmt1->close();
    }
}

// Function to get location from IP address
function isPrivateIP($ip) {
    $private_ranges = [
        '10.0.0.0' => '10.255.255.255',
        '172.16.0.0' => '172.31.255.255',
        '192.168.0.0' => '192.168.255.255',
    ];

    foreach ($private_ranges as $start => $end) {
        if (ip2long($ip) >= ip2long($start) && ip2long($ip) <= ip2long($end)) {
            return true;
        }
    }
    return false;
}

function getLocationFromIP($ip) {
    if (isPrivateIP($ip)) {
        return "Private IP Address";
    }

    $url = "http://ip-api.com/json/{$ip}";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data['status'] == 'success') {
        return "{$data['city']}, {$data['regionName']}, {$data['country']}";
    } else {
        return "Unknown";
    }
}
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
                <form id="admin-logout-form" method="POST" action="admin_audit_logs.php">
                    <a><button type="submit" class="logoutBtn" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
                </form>
            <?php } ?>
        </nav>
        <main>
            <h2>Verify Activity Logs</h2>
            <p id="responseMessage">Loading Results...</p><br>
            <p id="responseMessage1"></p><br>
            <p id="responseMessage2"></p><br>
            <p id="responseMessage3"></p><br>
            <p id="responseMessage4"></p><br>
            <a href="admin_audit_logs.php"><button>Go back</button></a>

            <div class="container">
                <div class="plot-container">
                    <div class="plot">
                        <h2>Elbow Method</h2>
                        <img id="elbow-method" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Cluster Distribution</h2>
                        <img id="cluster-distribution" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Time Distribution (Hours)</h2>
                        <img id="time-distribution" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Action Distribution</h2>
                        <img id="action-distribution" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Status Distribution</h2>
                        <img id="status-distribution" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Distance Distribution</h2>
                        <img id="distance-distribution" alt="Loading Image...">
                    </div>
                    <div class="plot">
                        <h2>Anomalies vs. Non-anomalies</h2>
                        <img id="anomalies-vs-non-anomalies" alt="Loading Image...">
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
<script src="js/admin_verify_audit_logs.js"></script>
<?php
include("includes/admin_footer.php");
?>