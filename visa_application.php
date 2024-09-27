<?php 
include("includes/header.php");
//if user is not logged in then take user to login page
if(!isset($_SESSION['userID'])){
    $log_action = "user view visa application";
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
    $log_action = "user view visa application";
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
        <h1>Home Affairs: Visa Application</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <form id="visa-form" method="POST" action="server/get_visa_application.php">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" placeholder="Enter Full Name" required>

            <label for="passportNumber">Passport Number</label>
            <input type="text" id="passportNumber" name="passportNumber" placeholder="Enter Passport Number" required>

            <label for="nationality">Nationality</label>
            <input type="text" id="nationality" name="nationality" placeholder="Enter Nationality" required>

            <label for="dateOfBirth">Date of Birth</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" required>

            <label for="visaType">Visa Type</label>
            <select id="visaType" name="visaType" required>
                <option value="" disabled selected>Select Visa Type</option>
                <option value="tourist">Tourist</option>
                <option value="business">Business</option>
                <option value="student">Student</option>
                <option value="work">Work</option>
            </select>

            <label for="entryDate">Intended Date of Entry</label>
            <input type="date" id="entryDate" name="entryDate" required>

            <label for="stayDuration">Duration of Stay (days)</label>
            <input type="number" id="stayDuration" name="stayDuration" placeholder="Enter Duration of Stay" required>

            <label for="purpose">Purpose of Visit</label>
            <textarea id="purpose" name="purpose" placeholder="Enter Purpose of Visit" required></textarea>

            <label for="accommodation">Accommodation Details</label>
            <input type="text" id="accommodation" name="accommodation" placeholder="Enter Accommodation Details" required>

            <label for="financialMeans">Proof of Financial Means</label>
            <input type="file" id="financialMeans" name="financialMeans" required>

            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
            <button type="submit" id="submitVisa" name="submitVisa">Submit Application</button>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>