<?php
include("includes/header.php");
// Set session
if(!isset($_SESSION['userLoggedIn'])){
    $_SESSION['userLoggedIn'] = true;
}
//if user is not logged in then take user to login page
if(!isset($_GET['userID']) || $_SESSION['userLoggedIn'] == "false"){
    $log_action = "user view dashboard";
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

    // Set session
    $_SESSION['userLoggedIn'] = false;
    header("Location: login.php?error=Unauthorised Access. Trespassers will be prosecuted. Activity has been logged."); // Redirect to index
    exit();
}
else{
    $_SESSION['userID'] = $userID = $_GET['userID'];
    $_SESSION['userFirstName'] =  $_GET['userFirstName'];
    $_SESSION['userSurname'] =  $_GET['userSurname'];
    $_SESSION['userEmail'] =  $_GET['userEmail'];

    $log_action = "user view dashboard";
    $log_status = "success";

    // Get the IP address
    $log_ip_address = $_SERVER['REMOTE_ADDR'];

    // Get the location
    $log_location = getLocationFromIP($log_ip_address);

    $log_date = date('Y-m-d H:i:s');

    // Prepare SQL statement for audit log
    $stmt1 = $conn->prepare("INSERT INTO audit_logs (user_id, log_action, log_status, log_location, log_date)
    VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("sssss", $userID, $log_action, $log_status, $log_location, $log_date);

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
    <header>
        <h1>Home Affairs: Dashboard</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="view_citizenship.php">View Citizenship</a>
        <a href="view_visa.php">View Visa</a>
        <a href="view_civil.php">View Civil</a>
        <a href="view_id.php">View ID</a>
    </nav>
    
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <h2>Welcome, <?php echo $_SESSION['userFirstName']. " " . $_SESSION['userSurname'];?></h2>
        <p>Select a service to proceed:</p>
        <a href="citizenship_application.php" class="service-button">Citizenship Application</a>
        <a href="visa_application.php" class="service-button">Visa Application</a>
        <a href="civil_registration.php" class="service-button">Civil Registration</a>
        <a href="id_application.php" class="service-button">Identity Document Application</a>

        <div class="applications-section">
            <h3>Your Applications</h3>
            <p>No applications submitted yet.</p>
        </div>

        <form id="logout-form" method="POST" action="dashboard.php">
            <a><button type="submit" id="logoutBtn" name="logoutBtn">Logout</button></a>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>
