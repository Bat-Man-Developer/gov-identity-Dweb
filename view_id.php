<?php 
include("includes/header.php");
require('fpdf/fpdf.php'); // Make sure to include the FPDF library

//if user is not logged in then take user to login page
if(!isset($_SESSION['userID'])){
    $log_action = "user view id application status";
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

    // Prepare SQL statement to get user details
    $stmt = $conn->prepare("SELECT user_first_name, user_last_name, user_sex, user_dob, user_country, user_email, user_phone FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userID);
    if($stmt->execute()){
        $stmt->bind_result($firstName,$lastName,$sex,$dob,$country,$email,$phone);
        $stmt->store_result();
        $stmt->fetch();
        $stmt->close();
    }
    else{
        header("location: dashboard.php?error=Something went wrong. Try again or Contact Support.");
    }

    // Prepare SQL statement to get application status
    $stmt = $conn->prepare("SELECT id_application_photo_path, id_application_status, id_application_created_at, id_application_id_number, id_application_place_of_birth, id_application_address, id_application_father_name, id_application_mother_name, id_application_marital_status, id_application_occupation, id_application_document_type FROM id_applications WHERE user_id = ? ORDER BY id_application_created_at DESC LIMIT 1");
    $stmt->bind_param("i", $userID);
    if($stmt->execute()){
        $stmt->bind_result($applicationPhotoPath, $applicationStatus, $applicationDate, $idNumber, $placeOfBirth, $address, $fatherName, $motherName, $maritalStatus, $occupation, $documentType);
        $stmt->store_result();
        $hasApplication = $stmt->fetch();
        $stmt->close();
    }
    else{
        header("location: dashboard.php?error=Something went wrong. Try again or Contact Support.");
    }

    $log_action = "user view id application status";
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
        <h1>Home Affairs: Identity Document Application Status</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        
        <h2>Application Status</h2>
        <?php if($hasApplication): ?>
            <h3>ID Photo</h3>
            <img src="<?php echo $applicationPhotoPath; ?>" alt="ID Photo" style="border-radius: 5px; width: 10%; height: auto;">
            <p><strong>Status:</strong> <?php echo $applicationStatus; ?></p>
            <p><strong>Application Date:</strong> <?php echo $applicationDate; ?></p>
            <p><strong>ID Number:</strong> <?php echo $idNumber; ?></p>
            <p><strong>Document Type:</strong> <?php echo $documentType; ?></p>

            <a id="viewPdfButton" href="view_approved_id_pdf.php?userIDNumber=<?php echo $idNumber; ?>" target="_blank" <?php echo ($applicationStatus !== 'Approved') ? 'disabled' : ''; ?>>
                View Approved ID PDF
            </a>

            <h3>Application Details</h3>
            <p><strong>Place of Birth:</strong> <?php echo $placeOfBirth; ?></p>
            <p><strong>Address:</strong> <?php echo $address; ?></p>
            <p><strong>Father's Name:</strong> <?php echo $fatherName; ?></p>
            <p><strong>Mother's Name:</strong> <?php echo $motherName; ?></p>
            <p><strong>Marital Status:</strong> <?php echo $maritalStatus; ?></p>
            <p><strong>Occupation:</strong> <?php echo $occupation; ?></p>
        <?php else: ?>
            <p>No application found. Please submit an application.</p>
        <?php endif; ?>

        <h2>Personal Information</h2>
        <p><strong>Name:</strong> <?php echo $firstName . ' ' . $lastName; ?></p>
        <p><strong>Gender:</strong> <?php echo $sex; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
        <p><strong>Country:</strong> <?php echo $country; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Phone:</strong> <?php echo $phone; ?></p>
    </main>
</body>
</html>
<?php 
include("includes/footer.php");
?>