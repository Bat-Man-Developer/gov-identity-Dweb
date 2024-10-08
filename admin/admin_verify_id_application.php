<?php
include("includes/admin_header.php");
//if admin is not logged in then take admin to login page
if(!isset($_SESSION['adminID'])){
    $log_action = "admin verify id application";
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
    $log_action = "admin verify id application";
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

include("server/get_admin_verify_id_application.php");
?>
<body>
    <header>
        <h1>Home Affairs Admin: Verify ID Application</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_review_id_applications.php">Review ID Applications</a>
        <a href="admin_review_citizenship_applications.php">Review Citizenship Applications</a>
        <a href="admin_review_visa_applications.php">Review Visa Applications</a>
        <a href="admin_review_civil_registrations.php">Review Civil Registrations</a>
        <a href="admin_view_users.php">View Users</a>
        <a href="admin_audit_logs.php">Audit Logs</a>
        <?php if(isset($_SESSION['adminEmail'])){ ?>
            <form id="admin-logout-form" method="POST" action="admin_verify_id_application.php">
                <a><button type="submit" class="logoutBtn" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <h2>Verify ID Application</h2>
        <?php if ($application): ?>
            <div class="application-details">
                <p><strong>Application No.:</strong> <?php echo $application['id_application_id']; ?></p>
                <p><strong>User No.:</strong> <?php echo $application['user_id']; ?></p>
                <p><strong>User ID Photo.:</strong></p><img src="<?php echo $application['id_application_photo_path']; ?>" alt="Loading Image..." style="border-radius: 5px ;width: 20%; height: auto;">
                <p><strong>First Name:</strong> <?php echo $application['id_application_first_name']; ?></p>
                <p><strong>Last Name:</strong> <?php echo $application['id_application_last_name']; ?></p>
                <p><strong>Document Type:</strong> <?php echo $application['id_application_document_type']; ?></p>
                <p><strong>Status:</strong> <?php echo $application['id_application_status']; ?></p>
                <p><strong>Submission Date:</strong> <?php echo $application['id_application_created_at']; ?></p>
                <p><strong>User ID Signature.:</strong></p><img src="<?php echo $application['id_application_signature_path']; ?>" alt="Loading Image..." style="border-radius: 5px ;width: 20%; height: auto;">
           </div>
            <?php if (!isset($application['id_application_id_number']) || $application['id_application_id_number'] == '') { ?>
                <form method="POST" action="admin_verify_id_application.php">
                    <div id="responseContainer">
                        <p class="response-message" id="responseMessage">Generating New ID Number...</p><br>
                        <input class="response-message" id="responseMessage" type="hidden" name="id_application_id_number" value=""/>
                    </div>
                    <input type="hidden" name="id_application_id" value="<?php echo $application['id_application_id']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $application['user_id']; ?>">
                    <button type="submit" name="assignNewIDNumber" class="action-button">Assign New ID Number</button>
                </form>
            <?php } else { ?>
                <form>
                    <div id="responseContainer1">
                        <p style="color: red; font-weight: bold">ID Number Already Exists. Cannot Generate New ID Number.</p><br>
                    </div>
                    <a href="admin_review_id_applications.php" class="action-button" style="text-align: center">Cancel</a>
                </form>
            <?php } ?>
        <?php else: ?>
            <p>Application not found.</p>
        <?php endif; ?>
    </main>
</body>
<script src="js/admin_verify_id_application.js"></script>
<?php
include("includes/admin_footer.php");
?>