<?php
include("connection.php"); // Include database connection file

if (isset($_POST['loginBtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT user_id, user_first_name, user_last_name, user_password FROM users WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    if($stmt->execute()){
        $stmt->bind_result($userID,$firstName,$lastName,$hashedPassword);
        $stmt->store_result();
    }
    else{
        header("location: ../login.php?error=Something went wrong. Try again or Contact Support.");
    }
    
    if ($stmt->num_rows == 1) {
        $stmt->fetch();
        $stmt->close();
        // Verify the password
        if (password_verify($password, $hashedPassword)) {    
            // Set log variables
            $log_action = "user login";
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
            
            header("Location: ../dashboard.php?success=Logged in successfully&userID=" . $userID . "&userFirstName=" . $firstName . "&userLastName=" . $lastName . "&userEmail=" . $email); // Redirect to the dashboard
            exit();
        } else {
            header("Location: ../login.php?error=Invalid password");
        }
    } else {
        $stmt->close();
        header("Location: ../login.php?error=Invalid email");
    }
}else {
    $log_action = "user login";
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