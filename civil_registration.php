<?php 
include("includes/header.php");
//if user is not logged in then take user to login page
if(!isset($_SESSION['userID'])){
    $log_action = "user view civil registration";
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

    header("Location: login.php?error=Unauthorised Access. Trespassers will be prosecuted. Activity has been logged."); // Redirect to index
    exit();
}
else{
    $userID = $_SESSION['userID'];
    $log_action = "user view civil registration";
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
        <h1>Home Affairs: Civil Registration</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <form id="civil-registration-form" method="POST" action="server/get_civil_registration.php">
            <label for="registrationType">Registration Type</label>
            <select id="registrationType" name="registrationType" required>
                <option value="" disabled selected>Select Registration Type</option>
                <option value="birth">Birth Registration</option>
                <option value="marriage">Marriage Registration</option>
                <option value="death">Death Registration</option>
            </select>

            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" placeholder="Enter Full Name" required>

            <label for="dateOfEvent">Date of Event</label>
            <input type="date" id="dateOfEvent" name="dateOfEvent" required>

            <label for="placeOfEvent">Place of Event</label>
            <input type="text" id="placeOfEvent" name="placeOfEvent" placeholder="Enter Place of Event" required>

            <label for="fatherName">Father's Name</label>
            <input type="text" id="fatherName" name="fatherName" placeholder="Enter Father's Name" required>

            <label for="motherName">Mother's Name</label>
            <input type="text" id="motherName" name="motherName" placeholder="Enter Mother's Name" required>

            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="nationality">Nationality</label>
            <input type="text" id="nationality" name="nationality" placeholder="Enter Nationality" required>

            <label for="address">Address</label>
            <textarea id="address" name="address" placeholder="Enter Address" required></textarea>

            <label for="contactNumber">Contact Number</label>
            <input type="tel" id="contactNumber" name="contactNumber" placeholder="Enter Contact Number" required>

            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
            <button type="submit" id="submitRegistration" name="submitRegistration">Submit Registration</button>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>