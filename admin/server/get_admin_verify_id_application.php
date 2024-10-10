<?php
if (isset($_POST['assignNewIDNumber'])) {
    $applicationID = $_POST['id_application_id'];
    $userID = $_POST['user_id'];
    // Assuming $_POST['id_application_id_number'] is set
    if (isset($_POST['id_application_id_number'])) {
        $applicationIDNumber = $_POST['id_application_id_number'];

        // Use regular expression to find the number
        if (preg_match('/(\d+)/', $applicationIDNumber, $matches, PREG_OFFSET_CAPTURE)) {
            // $matches[0][0] contains the number, and $matches[0][1] contains the starting position
            $number = $matches[0][0]; // The extracted number
            $startPos = $matches[0][1]; // Starting position of the number
            $endPos = $startPos + strlen($number) - 1; // Ending position of the number

            // Store in variable
            $applicationIDNumber = $number;
        } else {
            header("Location: admin_review_id_applications.php?error=Error. No ID number found.");
            exit;
        }
    } else {
        header("Location: admin_review_id_applications.php?error=Error. No ID number found.");
        exit;
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE id_applications SET id_application_id_number = ? WHERE id_application_id = ? AND user_id = ?");

    // Bind parameters
    $stmt->bind_param("sss", $applicationIDNumber, $applicationID, $userID);

    // Execute and check for success
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: admin_review_id_applications.php?success=ID Number Assigned Successfully. Finalize ID Application Approval.");
        exit;
    } else {
        // Handle error
        // You might want to log the error or provide feedback to the user
        echo "Error updating record: " . $stmt->error;
    }
}

$log_action = "admin view server verify id application";
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

// Save id appplications to CSV
function saveIDApplicationsToCSV($conn, $filename = 'datasets/id_applications.csv') {
    $query = "SELECT * FROM id_applications";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $file = fopen($filename, 'w');

        // Write headers
        $headers = array('index', 'user_id', 'first_name', 'last_name', 'date_of_birth', 'place_of_birth', 'gender', 'nationality', 'address', 'father_name', 'mother_name', 'marital_status', 'occupation', 'document_type', 'photo_path', 'signature_path', 'status', 'updated_at', 'created_at');
        fputcsv($file, $headers);

        // Write data
        while ($row = $result->fetch_assoc()) {
            fputcsv($file, $row);
        }

        fclose($file);
        return true;
    } else {
        return false;
    }
}

function saveVerifyIDApplicationToCSV($conn, $filename = 'datasets/verify_id_application.csv') {
    if (isset($_GET['id_application_id'])) {
        $query = "SELECT * FROM id_applications WHERE id_application_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET['id_application_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $file = fopen($filename, 'w');
            if ($file === false) {
                error_log("Failed to open file: $filename");
                return false;
            }

            // Write headers
            $headers = array('application_id', 'user_id', 'first_name', 'last_name', 'date_of_birth', 'place_of_birth', 'gender', 'nationality', 'address', 'father_name', 'mother_name', 'marital_status', 'occupation', 'document_type', 'photo_path', 'signature_path', 'id_number', 'status', 'updated_at', 'created_at');
            fputcsv($file, $headers);

            // Write data
            $row = $result->fetch_assoc();
            fputcsv($file, $row);

            fclose($file);
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    } else {
        return false;
    }
}

// Call the function to save id applications to CSV
if (saveIDApplicationsToCSV($conn)) {
    // Call the function to save verify id application to CSV
    if (saveVerifyIDApplicationToCSV($conn)) {
        // Get the application ID from the URL
        $application_id = isset($_GET['id_application_id']) ? $_GET['id_application_id'] : null;

        // Fetch application details
        if ($application_id) {
            $stmt = $conn->prepare("SELECT * FROM id_applications WHERE id_application_id = ?");
            $stmt->bind_param("i", $application_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $application = $result->fetch_assoc();
            $stmt->close();
        }
    } else {
        echo "No verify id applications found or error saving to CSV.";
    }

} else {
    echo "No id applications found or error saving to CSV.";
}