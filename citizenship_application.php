<?php 
include("includes/header.php");
include("server/get_citizenship_application.php");
?>
<body>
    <header>
        <h1>Home Affairs: Citizenship Application</h1>
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
        <form id="citizenship-form" method="POST" action="citizenship_application.php">
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

            <button type="submit" id="submitCitizenship" name="submitCitizenship">Submit Application</button>
        </form>
    </main>
</body>
<?php 
include("includes/footer.php");
?>