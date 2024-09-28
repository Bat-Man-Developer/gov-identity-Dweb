<?php 
include("includes/header.php");
//if user is not logged in then take user to login page
if(!isset($_SESSION['userID'])){
    $log_action = "user view id application";
    $log_status = "failed";
    $log_location = $_SERVER['REMOTE_ADDR'];
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
    $log_action = "user view id application";
    $log_status = "success";
    $log_location = $_SERVER['REMOTE_ADDR'];
    $log_date = date('Y-m-d H:i:s');

    // Prepare SQL statement for audit log
    $stmt1 = $conn->prepare("INSERT INTO audit_logs (user_id, log_action, log_status, log_location, log_date)
    VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("sssss", $userID, $log_action, $log_status, $log_location, $log_date);

    if ($stmt1->execute()) {
        $stmt1->close();
    }
}
?>
<body>
    <header>
        <h1>Home Affairs: Identity Document Application</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <form id="id-application-form" method="POST" action="server/get_id_application.php" enctype="multipart/form-data">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" placeholder="Enter Full Name" required>

            <label for="dateOfBirth">Date of Birth</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" required>

            <label for="placeOfBirth">Place of Birth</label>
            <input type="text" id="placeOfBirth" name="placeOfBirth" placeholder="Enter Place of Birth" required>

            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="nationality">Nationality</label>
            <input type="text" id="nationality" name="nationality" placeholder="Enter Nationality" required>

            <label for="address">Current Address</label>
            <textarea id="address" name="address" placeholder="Enter Current Address" required></textarea>

            <label for="fatherName">Father's Name</label>
            <input type="text" id="fatherName" name="fatherName" placeholder="Enter Father's Name" required>

            <label for="motherName">Mother's Name</label>
            <input type="text" id="motherName" name="motherName" placeholder="Enter Mother's Name" required>

            <label for="maritalStatus">Marital Status</label>
            <select id="maritalStatus" name="maritalStatus" required>
                <option value="" disabled selected>Select Marital Status</option>
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="divorced">Divorced</option>
                <option value="widowed">Widowed</option>
            </select>

            <label for="occupation">Occupation</label>
            <input type="text" id="occupation" name="occupation" placeholder="Enter Occupation" required>

            <label for="photo">Passport-sized Photo</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>

            <label for="signature">Digital Signature</label>
            <input type="file" id="signature" name="signature" accept="image/*" required>

            <label for="documentType">Document Type</label>
            <select id="documentType" name="documentType" required>
                <option value="" disabled selected>Select Document Type</option>
                <option value="nationalID">National ID Card</option>
                <option value="passport">Passport</option>
            </select>

            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
            <button type="submit" id="submitIDApplication" name="submitIDApplication">Submit Application</button>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>