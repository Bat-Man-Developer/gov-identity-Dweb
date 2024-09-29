<?php
include("includes/admin_header.php");
//if admin is not logged in then take admin to login page
if(!isset($_SESSION['adminID'])){
    $log_action = "admin view users";
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
    $log_action = "admin view users";
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
}
?>
<body>
    <header>
        <h1>Home Affairs Admin: View Users</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>  
    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_review_citizenship.php">Citizenship Applications</a>
        <a href="admin_review_visa.php">Visa Applications</a>
        <a href="admin_review_civil_registration.php">Civil Registrations</a>
        <a href="admin_review_id_applications.php">ID Applications</a>
        <a href="admin_audit_logs.php">Audit Logs</a>
        <?php if(isset($_SESSION['adminEmail'])){ ?>
            <form id="admin-logout-form" method="POST" action="admin_view_users.php">
                <a><button type="submit" class="logoutBtn" id="adminLogoutBtn" name="adminLogoutBtn">Logout</button></a>
            </form>
        <?php } ?>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <h2>User List</h2>
        <table>
            <thead>
                <tr>
                    <th>User No.</th>
                    <th>Name</th>
                    <th>Sex</th>
                    <th>Country</th>
                    <th>Email</th>
                    <th>Cell Number</th>
                    <th>Verification Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php include('server/get_admin_view_users.php');
                    foreach($users as $user){?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo $user['user_first_name'] . " " . $user['user_surname']; ?></td>
                    <td><?php echo $user['user_sex']; ?></td>
                    <td><?php echo $user['user_country']; ?></td>
                    <td><?php echo $user['user_email']; ?></td>
                    <td><?php echo $user['user_phone']; ?></td>
                    <td><?php echo $user['user_status']; ?></td>
                    <td>
                        <a href="admin_verify_user.php?user_id=<?php echo $user['user_id']; ?>" class="verify-button">Verify</a><br>
                        <a href="admin_edit_user.php?user_id=<?php echo $user['user_id']; ?>" class="action-button">Edit</a>
                        <a href="admin_delete_user.php?user_id=<?php echo $user['user_id']; ?>" class="action-button">Delete</a>
                    </td>
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
</body>
<?php
include("includes/admin_footer.php");
?>
