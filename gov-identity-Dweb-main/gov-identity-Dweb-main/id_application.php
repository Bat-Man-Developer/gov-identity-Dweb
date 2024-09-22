<?php 
include("includes/header.php");
include("server/get_id_application.php");
?>
<body>
    <header>
        <h1>Home Affairs: Identity Document Application</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="news.php">News</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <a href="about.php">About</a>
        <a href="team.php">Team</a>
    </nav>
    <main>
        <!------------- Website Messages----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo $_GET['success']; }?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
        <form id="id-application-form" method="POST" action="id_application.php" enctype="multipart/form-data">
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
                <option value="drivingLicense">Driving License</option>
            </select>

            <button type="submit" id="submitIDApplication" name="submitIDApplication">Submit Application</button>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>