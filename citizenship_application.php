<?php 
include("includes/header.php");
//if user is not logged in then take user to login page
if(!isset($_SESSION['userID'])){
    $log_action = "user view citizenship application";
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
    $log_action = "user view citizenship application";
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
        <h1>Home Affairs: Citizenship Application</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <form id="citizenship-form" method="POST" action="server/get_citizenship_application.php">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" placeholder="Enter Full Name" required>

            <label for="dateOfBirth">Date of Birth</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" required>

            <label for="placeOfBirth">Place of Birth</label>
            <input type="text" id="placeOfBirth" name="placeOfBirth" placeholder="Enter Place of Birth" required>

            <label for="currentNationality">Current Nationality</label>
            <input type="text" id="currentNationality" name="currentNationality" placeholder="Enter Current Nationality" required>

            <label for="residenceYears">Years of Residence</label>
            <input type="number" id="residenceYears" name="residenceYears" placeholder="Enter Years of Residence" required>

            <label for="languageProficiency">Language Proficiency</label>
            <select id="languageProficiency" name="languageProficiency" required>
                <option value="" disabled selected>Select Proficiency Level</option>
                <option value="basic">Basic</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
                <option value="native">Native</option>
            </select>

            <label for="criminalRecord">Criminal Record</label>
            <select id="criminalRecord" name="criminalRecord" required>
                <option value="" disabled selected>Select Option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>

            <label for="employmentStatus">Employment Status</label>
            <input type="text" id="employmentStatus" name="employmentStatus" placeholder="Enter Employment Status" required>

            <label for="reasonForApplication">Reason for Application</label>
            <textarea id="reasonForApplication" name="reasonForApplication" placeholder="Enter Reason for Application" required></textarea>

            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
            <button type="submit" id="submitCitizenship" name="submitCitizenship">Submit Application</button>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>