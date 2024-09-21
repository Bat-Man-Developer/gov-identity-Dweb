<?php 
include("includes/header.php");
include("server/get_civil_registration.php");
?>
<body>
    <header>
        <h1>Home Affairs: Civil Registration</h1>
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
        <form id="civil-registration-form" method="POST" action="civil_registration.php">
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

            <button type="submit" id="submitRegistration" name="submitRegistration">Submit Registration</button>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>