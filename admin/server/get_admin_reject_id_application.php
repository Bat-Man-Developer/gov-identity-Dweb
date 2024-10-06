<?php
// Get the application ID from the URL
$application_id = isset($_GET['id_application_id']) ? $_GET['id_application_id'] : null;

// Process the rejection
if ($application_id && isset($_POST['confirm_rejection'])) {
    $rejection_reason = $_POST['rejection_reason'];
    $stmt = $conn->prepare("UPDATE id_applications SET id_application_status = 'Rejected', id_application_rejection_reason = ? WHERE id_application_id = ?");
    $stmt->bind_param("si", $rejection_reason, $application_id);
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