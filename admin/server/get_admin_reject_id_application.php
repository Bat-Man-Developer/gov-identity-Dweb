<?php
// Get the application ID from the URL
if(isset($_GET['id_application_id'])){
    $application_id = $_GET['id_application_id'];
}

// POST the application ID from the URL
if(isset($_POST['id_application_id'])){
    $application_id = $_POST['id_application_id'];
}

// Process the rejection
if ($application_id && isset($_POST['rejectIDApplication'])) {
    $stmt = $conn->prepare("UPDATE id_applications SET id_application_status = 'Rejected' WHERE id_application_id = ?");
    $stmt->bind_param("i",$application_id);
    if ($stmt->execute()) {
        header("Location: admin_review_id_applications.php?success=Application rejected successfully");
        exit();
    } else {
        $error = "Failed to reject application";
    }
    $stmt->close();
}

// Fetch application details
if ($application_id) {
    $stmt = $conn->prepare("SELECT * FROM id_applications WHERE id_application_id = ?");
    $stmt->bind_param("i", $application_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();
    $stmt->close();
}